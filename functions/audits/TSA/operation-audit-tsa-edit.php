<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

    // check permission to access this page or function
    if(checkPermission('operations-audit-TSA-edit')) {

        $err = 0;

        // TSA Data
            
            $tsa_id = $_POST['tsa_id'];

            $status = '0';
            if(isset($_POST['save_status'])) {
                $status = trim($_POST['save_status']);
            }

            $sql = $pdo->prepare("SELECT * FROM operations_audit_tsa WHERE id = :id");
            $sql->bindParam(":id",$tsa_id);
            $sql->execute();
            $_data = $sql->fetch(PDO::FETCH_ASSOC);
            if(!$sql->rowCount()) {
                $err++;
            }

            $date_of_audit = '';
            if(isset($_POST['date_of_audit'])) {
                $date_of_audit = trim($_POST['date_of_audit']);
            }

            $date_presented = '';
            if(isset($_POST['date_presented'])) {
                $date_presented = trim($_POST['date_presented']);
            }

        // Section 1
            $summary = '';
            if(isset($_POST['summary'])) {
                $summary = trim($_POST['summary']);
            }

        // Section 2
            $building_description = '';
            if(isset($_POST['building_description'])) {
                $building_description = $_POST['building_description'];
            }

            $building_picture = '';
            if(isset($_FILES['building_picture']['name'])) {
                $building_picture = $_FILES['building_picture']['name'];
            }

        // Section 3

            # A. Compliances and Non Conformances Item

                $non_conformance_id = array();
                if(isset($_POST['non_conformance_id'])) {
                    $non_conformance_id = $_POST['non_conformance_id'];
                }

                $non_conformances = array();
                if(isset($_POST['non_conformance'])) {
                    $non_conformances = $_POST['non_conformance'];
                }

                $nc_status = array();
                if(isset($_POST['nc_status'])) {
                    $nc_status = $_POST['nc_status'];
                }

                $nc_remarks = array();
                if(isset($_POST['nc_remarks'])) {
                    $nc_remarks = $_POST['nc_remarks'];
                }

                $nc_years = '';
                if(isset($_POST['nc_years'])) {
                    $nc_years = $_POST['nc_years'];
                }

            // system

                $system_id = array();
                if(isset($_POST['system_id'])) {
                    $system_id = $_POST['system_id'];
                }

                $location_category = array();
                if(isset($_POST['location_category'])) {
                    $location_category = $_POST['location_category'];
                }

                $location_details = array();
                if(isset($_POST['location_details'])) {
                    $location_details = $_POST['location_details'];
                }

                $location_notes = array();
                if(isset($_POST['notes'])) {
                    $location_notes = $_POST['notes'];
                }

            // system locations
                $location_ids = array();
                if(isset($_POST['location_id'])) {
                    $location_ids = $_POST['location_id'];
                }
                
                $location_code = array();
                if(isset($_POST['location_code'])) {
                    $location_code = $_POST['location_code'];
                }

                $location = array();
                if(isset($_POST['location'])) {
                    $location = $_POST['location'];
                }

                $location_unit = array();
                if(isset($_POST['location_unit'])) {
                    $location_unit = $_POST['location_unit'];
                }

                $location_remarks = array();
                if(isset($_POST['location_remarks'])) {
                    $location_remarks = $_POST['location_remarks'];
                }
                
                $location_findings = array();
                if(isset($_POST['findings'])) {
                    $location_findings = $_POST['findings'];
                }

                $location_priority = array();
                if(isset($_POST['priority'])) {
                    $location_priority = $_POST['priority'];
                }

                $location_priority_specify = array();
                if(isset($_POST['priority_specify'])) {
                    $location_priority_specify = $_POST['priority_specify'];
                }
                
                $location_recommendation = array();
                if(isset($_POST['location_recommendation'])) {
                    $location_recommendation = $_POST['location_recommendation'];
                }

            // system units

                $location_unit_id = array();
                if(isset($_POST['location_unit_id'])) {
                    $location_unit_id = $_POST['location_unit_id'];
                }

                $unit_specification_category = array();
                if(isset($_POST['specification_category'])) {
                    $unit_specification_category = $_POST['specification_category'];
                }

                $unit_specification = array();
                if(isset($_POST['specification'])) {
                    $unit_specification = $_POST['specification'];
                }

                $unit_data = array();
                if(isset($_POST['data'])) {
                    $unit_data = $_POST['data'];
                }

            // system pictures

                $picture_ids = array();
                if(isset($_POST['picture_id'])) {
                    $picture_ids = $_POST['picture_id'];
                }

                $pictures = array();
                if(isset($_FILES['pictures']['name'])) {
                    $pictures = $_FILES['pictures'];
                }

                $picture_findings = array();
                if(isset($_POST['picture_findings'])) {
                    $picture_findings = $_POST['picture_findings'];
                }

                $picture_priority = array();
                if(isset($_POST['picture_priority'])) {
                    $picture_priority = $_POST['picture_priority'];
                }

                $picture_priority_specify = array();
                if(isset($_POST['picture_priority_specify'])) {
                    $picture_priority_specify = $_POST['picture_priority_specify'];
                }

                $picture_recommendations = array();
                if(isset($_POST['picture_recommendations'])) {
                    $picture_recommendations = $_POST['picture_recommendations'];
                }

                $picture_code = array();
                if(isset($_POST['picture_code'])) {
                    $picture_code = $_POST['picture_code'];
                }
            // 

            // FIRE EXTINGUISHERS AND EMERGENCY LIGHTS

                // fire safety

                    $fire_safety_id = array();
                    if(isset($_POST['fire_safety_id'])) {
                        $fire_safety_id = $_POST['fire_safety_id'];
                    }

                    $fire_safety_category = array();
                    if(isset($_POST['fire_safety_category'])) {
                        $fire_safety_category = $_POST['fire_safety_category'];
                    }

                    $fire_safety_details = array();
                    if(isset($_POST['fire_safety_details'])) {
                        $fire_safety_details = $_POST['fire_safety_details'];
                    }

                // site
                    $fire_safety_site_id = array();
                    if(isset($_POST['fire_safety_site_id'])) {
                        $fire_safety_site_id = $_POST['fire_safety_site_id'];
                    }

                    $fire_safety_site = array();
                    if(isset($_POST['fire_safety_site'])) {
                        $fire_safety_site = $_POST['fire_safety_site'];
                    }

                    $fire_safety_code = array();
                    if(isset($_POST['fire_safety_code'])) {
                        $fire_safety_code = $_POST['fire_safety_code'];
                    }

                    $fire_safety_site_category = array();
                    if(isset($_POST['fire_safety_site_category'])) {
                        $fire_safety_site_category = $_POST['fire_safety_site_category'];
                    }

                //location
                    $fire_safety_location = array();
                    if(isset($_POST['fire_safety_location'])) {
                        $fire_safety_location = $_POST['fire_safety_location'];
                    }

                    $fire_safety_type = array();
                    if(isset($_POST['fire_safety_type'])) {
                        $fire_safety_type = $_POST['fire_safety_type'];
                    }

                    $fire_safety_quantity = array();
                    if(isset($_POST['fire_safety_quantity'])) {
                        $fire_safety_quantity = $_POST['fire_safety_quantity'];
                    }

                    $fire_safety_capacity = array();
                    if(isset($_POST['fire_safety_capacity'])) {
                        $fire_safety_capacity = $_POST['fire_safety_capacity'];
                    }

                    $fire_safety_date = array();
                    if(isset($_POST['fire_safety_date'])) {
                        $fire_safety_date = $_POST['fire_safety_date'];
                    }

                    $fire_safety_loc_category = array();
                    if(isset($_POST['fire_safety_loc_category'])) {
                        $fire_safety_loc_category = $_POST['fire_safety_loc_category'];
                    }

                    $fire_safety_site_loc_id = array();
                    if(isset($_POST['fire_safety_site_loc_id'])) {
                        $fire_safety_site_loc_id = $_POST['fire_safety_site_loc_id'];
                    }

        // Section 4

            // Safety Inspection Checklist

                $sic_id = array();
                if(isset($_POST['sic_id'])) {
                    $sic_id = $_POST['sic_id'];
                }

                $sic_particulars = array();
                if(isset($_POST['sic_particulars'])) {
                    $sic_particulars = $_POST['sic_particulars'];
                }

                $sic_standards = array();
                if(isset($_POST['sic_standards'])) {
                    $sic_standards = $_POST['sic_standards'];
                } 

                $sic_check_status = array();
                if(isset($_POST['sic_check_status'])) {
                    $sic_check_status = $_POST['sic_check_status'];
                }

                $sic_remarks = array();
                if(isset($_POST['sic_remarks'])) {
                    $sic_remarks = $_POST['sic_remarks'];
                } 

        // Section 5

            $permit_id = array();
            if(isset($_POST['permit_id'])) {
                $permit_id = $_POST['permit_id'];
            }

            $pre_ops_permit_id = array();
            if(isset($_POST['pre_ops_permit_id'])) {
                $pre_ops_permit_id = $_POST['pre_ops_permit_id'];
            }

            $permit_particulars = array();
            if(isset($_POST['particulars'])) {
                $permit_particulars = $_POST['particulars'];
            }

            $permit_date_of_issuance = array();
            if(isset($_POST['permit_date_of_issuance'])) {
                $permit_date_of_issuance = $_POST['permit_date_of_issuance'];
            }

            $permit_findings = array();
            if(isset($_POST['permit_findings'])) {
                $permit_findings = $_POST['permit_findings'];
            }

            $permit_priority = array();
            if(isset($_POST['permit_priority'])) {
                $permit_priority = $_POST['permit_priority'];
            }

            $permit_priority_specify = array();
            if(isset($_POST['permit_priority_specify'])) {
                $permit_priority_specify = $_POST['permit_priority_specify'];
            }

            $permit_recommendation = array();
            if(isset($_POST['permit_recommendation'])) {
                $permit_recommendation = $_POST['permit_recommendation'];
            }

        // Section 6

            // As-Built Plans

                $as_built_id = array();
                if(isset($_POST['as_built_id'])) {
                    $as_built_id = $_POST['as_built_id'];
                }

                $as_built_description = array();
                if(isset($_POST['as_built_description'])) {
                    $as_built_description = $_POST['as_built_description'];
                }

                $sheets = array();
                if(isset($_POST['sheets'])) {
                    $sheets = $_POST['sheets'];
                }

                $as_built_recommendation = array();
                if(isset($_POST['as_built_recommendation'])) {
                    $as_built_recommendation = $_POST['as_built_recommendation'];
                }

                $as_built_findings = array();
                if(isset($_POST['as_built_findings'])) {
                    $as_built_findings = $_POST['as_built_findings'];
                }

                $as_built_priority = array();
                if(isset($_POST['as_built_priority'])) {
                    $as_built_priority = $_POST['as_built_priority'];
                }

                $as_built_priority_specify = array();
                if(isset($_POST['as_built_priority_specify'])) {
                    $as_built_priority_specify = $_POST['as_built_priority_specify'];
                }

            // Equipment Manuals

                $manual_equip_id = array();
                if(isset($_POST['manual_equip_id'])) {
                    $manual_equip_id = $_POST['manual_equip_id'];
                }

                $manual_contractor = array();
                if(isset($_POST['manual_contractor'])) {
                    $manual_contractor = $_POST['manual_contractor'];
                }

                $manual_description = array();
                if(isset($_POST['manual_description'])) {
                    $manual_description = $_POST['manual_description'];
                }

                $manual_documents = array();
                if(isset($_POST['manual_documents'])) {
                    $manual_documents = $_POST['manual_documents'];
                }

                $manual_findings = array();
                if(isset($_POST['manual_findings'])) {
                    $manual_findings = $_POST['manual_findings'];
                }

                $manual_priority = array();
                if(isset($_POST['manual_priority'])) {
                    $manual_priority = $_POST['manual_priority'];
                }

                $manual_priority_specify = array();
                if(isset($_POST['manual_priority_specify'])) {
                    $manual_priority_specify = $_POST['manual_priority_specify'];
                }

                $manual_recommendation = array();
                if(isset($_POST['manual_recommendation'])) {
                    $manual_recommendation = $_POST['manual_recommendation'];
                }

        if ($err == 0) {

        //
            $sql = $pdo->prepare("UPDATE operations_audit_tsa SET
                date_of_audit = :date_of_audit, 
                date_presented = :date_presented, 
                summary = :summary, 
                building_description = :building_description, 
                building_picture = :building_picture,
                status = :save_status
            WHERE id = :tsa_id");
            $sql->bindParam("tsa_id", $tsa_id);
            $sql->bindParam("date_of_audit", $date_of_audit);
            $sql->bindParam("date_presented", $date_presented);
            $sql->bindParam("summary", $summary);
            $sql->bindParam("building_description", $building_description);
            $sql->bindParam("save_status", $status);


            // building picture
            $attachment_name = getField('building_picture', 'operations_audit_tsa', 'id = '.$tsa_id);
            if(!empty($building_picture)) {

                if(!is_dir($sys_upload_dir.'operations-audit')) {
                    mkdir($sys_upload_dir.'operations-audit', 0755, true);
                }

                $file = explode('.', $building_picture);
                $file_name = $file[0];
                $file_ext = $file[1];

                $time = time();

                $attachment_name = $file_name.'-'.$time.'.'.$file_ext;

                $file_tmp = $_FILES['building_picture']['tmp_name'];
                $file_size = $_FILES['building_picture']['size'];

                // save file
                move_uploaded_file($file_tmp, $sys_upload_dir.'operations-audit/'.$attachment_name);

            }

            $sql->bindParam("building_picture", $attachment_name);
            $sql->execute();

        // SECTION 3

            # A. Compliances and Non Conformances Item

                foreach ($non_conformance_id as $key => $conformance_id) {

                    // edit
                    $sql = $pdo->prepare("SELECT * FROM operations_audit_tsa_compliances_and_non_conformances WHERE id = :id");
                    $sql->bindParam(":id",$conformance_id);
                    $sql->execute();
                    if ($sql->rowcount()) {

                        $_data1 = $sql->fetch(PDO::FETCH_ASSOC);

                        $sql = $pdo->prepare("UPDATE operations_audit_tsa_compliances_and_non_conformances SET
                            non_conformance = :non_conformance,
                            status = :nc_status,
                            remarks = :nc_remarks,
                            years = :nc_years
                        WHERE id = :id AND tsa_id = :tsa_id");
                        $sql->bindParam(":tsa_id",$tsa_id);
                        $sql->bindParam(":id",$conformance_id);
                        $sql->bindParam(":non_conformance",$non_conformances[$key]);
                        $sql->bindParam(":nc_status",$nc_status[$key]);
                        $sql->bindParam(":nc_remarks",$nc_remarks[$key]);
                        $sql->bindParam(":nc_years",$nc_years[$key]);
                        $sql->execute();

                    } else {

                        if (!empty($non_conformances[$key]) || !empty($nc_status[$key]) || !empty($nc_remarks[$key])) {

                            // Compliances and Non Conformances Item Checklist INSERT FUNCTION
                            $sql = $pdo->prepare("INSERT INTO operations_audit_tsa_compliances_and_non_conformances (
                                tsa_id,
                                years,
                                non_conformance,
                                status,
                                remarks
                            ) VALUES (
                                :tsa_id,
                                :nc_years,
                                :non_conformance,
                                :nc_status,
                                :nc_remarks
                            )");
                            $sql->bindParam(":tsa_id",$tsa_id);
                            $sql->bindParam(":nc_years",$nc_years);
                            $sql->bindParam(":non_conformance",$non_conformances[$key]);
                            $sql->bindParam(":nc_status",$nc_status[$key]);
                            $sql->bindParam(":nc_remarks",$nc_remarks[$key]);
                            $sql->execute();
                        }

                    }
                }


                // set category
                $sql = $pdo->prepare("SELECT * FROM operations_audit_tsa_system WHERE tsa_id = :tsa_id");
                $sql->bindParam(":tsa_id", $tsa_id);
                $sql->execute();
                if($sql->rowCount()) { // update

                    $fetch = array();
                    while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                        $fetch[] = $data['id'];
                    }

                    foreach($system_id as $key => $id) { // update

                        if(in_array($id, $fetch)) {

                            $sql1 = $pdo->prepare("UPDATE operations_audit_tsa_system SET 
                                details = :details, 
                                notes = :notes 
                            WHERE id = :id");
                            $sql1->bindParam(":details", $location_details[$key]);
                            $sql1->bindParam(":notes", $location_notes[$key]);
                            $sql1->bindParam(":id", $id);
                            $sql1->execute();

                        }                   

                        // update location pictures
                            $sql1 = $pdo->prepare("SELECT * FROM operations_audit_tsa_system_pictures WHERE system_id = :id");
                            $sql1->bindParam(":id", $id);
                            $sql1->execute();
                            $tsa_picture_id = array();
                            $tsa_pictures = array();
                            while($data = $sql1->fetch(PDO::FETCH_ASSOC)) {
                                $tsa_picture_id[] = $data['id'];
                                $tsa_pictures[$data['id']] = $data['picture']; 
                            }

                            foreach($picture_ids as $pic_key => $picture_id) {

                                if(in_array($picture_id, $tsa_picture_id)) { // update

                                    $sql2 = $pdo->prepare("UPDATE operations_audit_tsa_system_pictures SET 
                                        picture = :picture, 
                                        findings = :picture_findings, 
                                        prioritization = :picture_priority, 
                                        prioritization_specify = :picture_priority_specify, 
                                        recommendations = :recommendation 
                                    WHERE id = :id");
                                    $sql2->bindParam(":id", $picture_id);

                                    $picture_attach = $tsa_pictures[$picture_id];
                                    if(!empty($pictures['name'][$pic_key])) {

                                        if(!is_dir($sys_upload_dir.'operations-audit-tsa-section3')) {
                                            mkdir($sys_upload_dir.'operations-audit-tsa-section3', 0755, true);
                                        }
                        
                                        $file = explode('.', $pictures['name'][$pic_key]);
                                        $file_name = $file[0];
                                        $file_ext = $file[1];
                        
                                        $time = time();
                        
                                        $picture_attach = $file_name.'-TSA-'.$time.'.'.$file_ext;
                        
                                        $file_tmp = $pictures['tmp_name'][$pic_key];
                                        $file_size = $pictures['size'][$pic_key];
                                        
                                        // save file
                                        move_uploaded_file($file_tmp, $sys_upload_dir.'operations-audit-tsa-section3/'.$picture_attach);

                                    }
                                    
                                    $sql2->bindParam(":picture", $picture_attach);
                                    $sql2->bindParam(":picture_findings", $picture_findings[$pic_key]);
                                    $sql2->bindParam(":picture_priority", $picture_priority[$pic_key]);
                                    $sql2->bindParam(":picture_priority_specify", $picture_priority_specify[$pic_key]);
                                    $sql2->bindParam(":recommendation", $picture_recommendations[$pic_key]);
                                    $sql2->execute();

                                } else { // insert

                                    if($location_category[$key] == $picture_code[$pic_key] && $picture_id == 0) {

                                        // insert system pictures
                                        $sql2 = $pdo->prepare("INSERT INTO operations_audit_tsa_system_pictures (
                                            system_id, 
                                            picture, 
                                            findings,
                                            prioritization,
                                            prioritization_specify,  
                                            recommendations
                                        ) VALUES (
                                            :system_id, 
                                            :picture, 
                                            :picture_findings, 
                                            :picture_priority, 
                                            :picture_priority_specify, 
                                            :recommendation
                                        )");
                                        $sql2->bindParam(":system_id", $id);

                                        $picture_attach = '';
                                        if(!empty($pictures['name'][$pic_key])) {

                                            if(!is_dir($sys_upload_dir.'operations-audit-tsa-section3')) {
                                                mkdir($sys_upload_dir.'operations-audit-tsa-section3', 0755, true);
                                            }
                            
                                            $file = explode('.', $pictures['name'][$pic_key]);
                                            $file_name = $file[0];
                                            $file_ext = $file[1];
                            
                                            $time = time();
                            
                                            $picture_attach = $file_name.'-TSA-'.$time.'.'.$file_ext;
                            
                                            $file_tmp = $pictures['tmp_name'][$pic_key];
                                            $file_size = $pictures['size'][$pic_key];
                                            
                                            // save file
                                            move_uploaded_file($file_tmp, $sys_upload_dir.'operations-audit-tsa-section3/'.$picture_attach);

                                            $sql2->bindParam(":picture", $picture_attach);
                                            $sql2->bindParam(":picture_findings", $picture_findings[$pic_key]);
                                            $sql2->bindParam(":picture_priority", $picture_priority[$pic_key]);
                                            $sql2->bindParam(":picture_priority_specify", $picture_priority_specify[$pic_key]);
                                            $sql2->bindParam(":recommendation", $picture_recommendations[$pic_key]);
                                            $sql2->execute();

                                        }

                                    }
                                }

                            }

                        // 
                        
                        // update system location units
                            $start = 0;
                            $end = 0;
                            $start_val = 0;
                            $end_val = 0;
                            foreach($location_ids as $location_key => $location_id) {

                                $sql = $pdo->prepare("SELECT * FROM operations_audit_tsa_system_locations WHERE id = :location_id AND system_id = :id");
                                $sql->bindParam(":location_id", $location_id);
                                $sql->bindParam(":id", $id);
                                $sql->execute();
                                $data = $sql->fetch(PDO::FETCH_ASSOC);

                                if($sql->rowCount()) { // update

                                    $data = $sql->fetch(PDO::FETCH_ASSOC);

                                    $sql1 = $pdo->prepare("UPDATE operations_audit_tsa_system_locations SET 
                                        location = :location, 
                                        unit = :unit,
                                        findings = :findings,
                                        prioritization = :prioritization,
                                        prioritization_specify = :prioritization_specify,
                                        recommendation = :recommendation
                                    WHERE id = :id");
                                    $sql1->bindParam(":id", $location_id);
                                    $sql1->bindParam(":location", $location[$location_key]);
                                    $sql1->bindParam(":unit", $location_unit[$location_key]);
                                    $sql1->bindParam(":findings", $location_findings[$location_key]);
                                    $sql1->bindParam(":prioritization", $location_priority[$location_key]);
                                    $sql1->bindParam(":prioritization_specify", $location_priority_specify[$location_key]);
                                    $sql1->bindParam(":recommendation", $location_recommendation[$location_key]);
                                    $sql1->execute();


                                    $unit_specification_category_val = array();
                                    if(isset($_POST[$location_code[$location_key].'_specification_category_val'])) {
                                        $unit_specification_category_val = $_POST[$location_code[$location_key].'_specification_category_val'];
                                    }

                                    $location_unit_id_val = array();
                                    if(isset($_POST[$location_code[$location_key].'_location_unit_id_val'])) {
                                        $location_unit_id_val = $_POST[$location_code[$location_key].'_location_unit_id_val'];
                                    }

                                    $unit_specification_val = array();
                                    if(isset($_POST[$location_code[$location_key].'_specification_val'])) {
                                        $unit_specification_val = $_POST[$location_code[$location_key].'_specification_val'];
                                    }

                                    $unit_data_val = array();
                                    if(isset($_POST[$location_code[$location_key].'_data_val'])) {
                                        $unit_data_val = $_POST[$location_code[$location_key].'_data_val'];
                                    }

                                    $num = count($tsa_section_3_arr[$location_code[$location_key]][1]);
                                    $end_val += $num;

                                    foreach($unit_specification_category_val as $spec_key => $spec) {

                                        if($location_unit_id_val[$spec_key] != 0) {

                                            $sql2 = $pdo->prepare("UPDATE operations_audit_tsa_system_units SET 
                                            specification = :specification, 
                                            operational_data = :data 
                                            WHERE id = :id");
                                            $sql2->bindParam(":id", $location_unit_id_val[$spec_key]);
                                            $sql2->bindParam(":specification", $unit_specification_val[$spec_key]);
                                            $sql2->bindParam(":data", $unit_data_val[$spec_key]);

                                            if($spec_key < $end_val && $spec_key >= $start_val) {
                                                $sql2->execute();
                                            }

                                        } else {

                                            $sql2 = $pdo->prepare("INSERT INTO operations_audit_tsa_system_units (
                                                location_id, 
                                                specification_category, 
                                                specification, 
                                                operational_data
                                            ) VALUES (
                                                :location_id, 
                                                :specification_category, 
                                                :specification, 
                                                :data
                                            )");

                                            
                                            $sql2->bindParam(":location_id", $location_id);
                                            $sql2->bindParam(":specification_category", $spec);
                                            $sql2->bindParam(":specification", $unit_specification_val[$spec_key]);
                                            $sql2->bindParam(":data", $unit_data_val[$spec_key]);
                                            if($spec_key < $end_val && $spec_key >= $start_val) {
                                                $sql2->execute();
                                            }

                                        }
                                    }
                                    $start_val = $start_val+$num;

                                } else { // insert

                                    if($location_category[$key] == $location_code[$location_key] && $location_id == 0) {
                                        

                                        $sql1 = $pdo->prepare("INSERT INTO operations_audit_tsa_system_locations (
                                            system_id, 
                                            location, 
                                            unit,
                                            findings,
                                            prioritization,
                                            prioritization_specify,
                                            recommendation
                                        ) VALUES (
                                            :system_id, 
                                            :location, 
                                            :unit,
                                            :findings,
                                            :prioritization,
                                            :prioritization_specify,
                                            :recommendation
                                        )");

                                        if(!empty($location[$location_key])) {

                                            $sql1->bindParam(":system_id", $id);
                                            $sql1->bindParam(":location", $location[$location_key]);
                                            $sql1->bindParam(":unit", $location_unit[$location_key]);
                                            $sql1->bindParam(":findings", $location_findings[$location_key]);
                                            $sql1->bindParam(":prioritization", $location_priority[$location_key]);
                                            $sql1->bindParam(":prioritization_specify", $location_priority_specify[$location_key]);
                                            $sql1->bindParam(":recommendation", $location_recommendation[$location_key]);
                                            $sql1->execute();

                                            $location_id = $pdo->lastInsertId();

                                            // insert system_locations

                                            $unit_specification_category = array();
                                            if(isset($_POST[$location_code[$location_key].'_specification_category'])) {
                                                $unit_specification_category = $_POST[$location_code[$location_key].'_specification_category'];
                                            }

                                            $unit_specification = array();
                                            if(isset($_POST[$location_code[$location_key].'_specification'])) {
                                                $unit_specification = $_POST[$location_code[$location_key].'_specification'];
                                            }

                                            $unit_data = array();
                                            if(isset($_POST[$location_code[$location_key].'_data'])) {
                                                $unit_data = $_POST[$location_code[$location_key].'_data'];
                                            }

                                            $num = count($tsa_section_3_arr[$location_code[$location_key]][1]);
                                            $end += $num;
                                            

                                            foreach($unit_specification_category as $spec_key => $spec) {

                                                $sql2 = $pdo->prepare("INSERT INTO operations_audit_tsa_system_units (
                                                    location_id, 
                                                    specification_category, 
                                                    specification, 
                                                    operational_data
                                                ) VALUES (
                                                    :location_id, 
                                                    :specification_category, 
                                                    :specification, 
                                                    :data
                                                )");
                                                
                                                $sql2->bindParam(":location_id", $location_id);
                                                $sql2->bindParam(":specification_category", $spec);
                                                $sql2->bindParam(":specification", $unit_specification[$spec_key]);
                                                $sql2->bindParam(":data", $unit_data[$spec_key]);
                                                if($spec_key < $end && $spec_key >= $start) {
                                                    $sql2->execute();
                                                }
                                            }
                                            $start = $start+$num;

                                        }

                                    }

                                }

                            }
                        // 
                    }

                }

                // FIRE EXTINGUISHERs AND EMERGENCY LIGHTS INSERT FUNCTION
                    $sql = $pdo->prepare("SELECT * FROM operations_audit_tsa_fire_safety_and_security WHERE tsa_id = :tsa_id");
                    $sql->bindParam(":tsa_id", $tsa_id);
                    $sql->execute();
                    if($sql->rowCount()){

                        $fetch = array();
                        while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
                            $fetch[] = $data['id'];
                        }

                        foreach ($fire_safety_id as $key => $safety_id) {
                            
                            if(in_array($safety_id, $fetch)) {

                                $sql1 = $pdo->prepare("UPDATE operations_audit_tsa_fire_safety_and_security SET 
                                    details = :fire_safety_details
                                WHERE id = :id");
                                $sql1->bindParam(":fire_safety_details", $fire_safety_details[$key]);
                                $sql1->bindParam(":id", $safety_id);
                                $sql1->execute();

                            }

                            foreach ($fire_safety_site_id as $key2 => $site_id) {

                                // update site
                                $sql1 = $pdo->prepare("SELECT * FROM operations_audit_tsa_fire_safety_and_security_site WHERE fire_safety_id = :fire_safety_id AND id = :site_id AND category = :category");
                                $sql1->bindParam(":fire_safety_id", $safety_id);
                                $sql1->bindParam(":site_id", $site_id);
                                $sql1->bindParam(":category", $fire_safety_site_category[$key2]);
                                $sql1->execute();
                                $site_lasinsert_id = array();
                                if ($sql1->rowcount()) {

                                    $_data = $sql->fetch(PDO::FETCH_ASSOC);

                                        //SITE UPDATE FUNCTION
                                        $sql2 = $pdo->prepare("UPDATE operations_audit_tsa_fire_safety_and_security_site SET
                                            site = :fire_safety_site
                                        WHERE id = :site_id");
                                        $sql2->bindParam(":site_id",$site_id);
                                        $sql2->bindParam(":fire_safety_site",$fire_safety_site[$key2]);
                                        $sql2->execute();

                                        //
                                        if ($fire_safety_code[$key2] == $fire_safety_category[$key]) {

                                            $fire_safety_location = array();
                                            if(isset($_POST[$fire_safety_code[$key2].'_location'])) {
                                                $fire_safety_location = $_POST[$fire_safety_code[$key2].'_location'];
                                            }

                                            $fire_safety_type = array();
                                            if(isset($_POST[$fire_safety_code[$key2].'_type'])) {
                                                $fire_safety_type = $_POST[$fire_safety_code[$key2].'_type'];
                                            }

                                            $fire_safety_quantity = array();
                                            if(isset($_POST[$fire_safety_code[$key2].'_quantity'])) {
                                                $fire_safety_quantity = $_POST[$fire_safety_code[$key2].'_quantity'];
                                            }

                                            $fire_safety_capacity = array();
                                            if(isset($_POST[$fire_safety_code[$key2].'_capacity'])) {
                                                $fire_safety_capacity = $_POST[$fire_safety_code[$key2].'_capacity'];
                                            }

                                            $fire_safety_date = array();
                                            if(isset($_POST[$fire_safety_code[$key2].'_date'])) {
                                                $fire_safety_date = $_POST[$fire_safety_code[$key2].'_date'];
                                            }

                                            $fire_safety_loc_category = array();
                                            if(isset($_POST[$fire_safety_code[$key2].'_loc_category'])) {
                                                $fire_safety_loc_category = $_POST[$fire_safety_code[$key2].'_loc_category'];
                                            }

                                            $fire_safety_loc_id = array();
                                            if(isset($_POST[$fire_safety_code[$key2].'_loc_id'])) {
                                                $fire_safety_loc_id = $_POST[$fire_safety_code[$key2].'_loc_id'];
                                            }

                                            foreach ($fire_safety_loc_id as $key3 => $loc_id) {

                                                // update site location
                                                $sql3 = $pdo->prepare("SELECT * FROM operations_audit_tsa_fire_safety_and_security_site_location WHERE id = :loc_id AND site_id = :site_id");
                                                $sql3->bindParam(":loc_id", $loc_id);
                                                $sql3->bindParam(":site_id", $site_id);
                                                $sql3->execute();
                                                if ($sql3->rowcount()) {

                                                    $_data2 = $sql3->fetch(PDO::FETCH_ASSOC);

                                                    //SITE LOCATION UPDATE FUNCTION
                                                    $sql4 = $pdo->prepare("UPDATE operations_audit_tsa_fire_safety_and_security_site_location SET
                                                        location = :fire_safety_location,
                                                        type = :fire_safety_type,
                                                        quantity = :fire_safety_quantity,
                                                        capacity = :fire_safety_capacity,
                                                        date_of_last_refill = :fire_safety_date
                                                    WHERE id = :loc_id AND site_id = :site_id");
                                                    $sql4->bindParam(":loc_id",$loc_id);
                                                    $sql4->bindParam(":site_id",$site_id);
                                                    $sql4->bindParam(":fire_safety_location",$fire_safety_location[$key3]);
                                                    $sql4->bindParam(":fire_safety_type",$fire_safety_type[$key3]);
                                                    $sql4->bindParam(":fire_safety_quantity",$fire_safety_quantity[$key3]);
                                                    $sql4->bindParam(":fire_safety_capacity",$fire_safety_capacity[$key3]);
                                                    $sql4->bindParam(":fire_safety_date",$fire_safety_date[$key3]);
                                                    $sql4->execute();

                                                    
                                                } else {

                                                    if ($fire_safety_site_category[$key2] == $fire_safety_loc_category[$key3]) {

                                                        if (checkVar($fire_safety_location[$key3])) {

                                                            //SITE INSERT FUNCTION
                                                            $sql4 = $pdo->prepare("INSERT INTO operations_audit_tsa_fire_safety_and_security_site_location (
                                                                site_id,
                                                                category,
                                                                location,
                                                                type,
                                                                quantity,
                                                                capacity,
                                                                date_of_last_refill
                                                            ) VALUES (
                                                                :site_id,
                                                                :fire_safety_loc_category,
                                                                :fire_safety_location,
                                                                :fire_safety_type,
                                                                :fire_safety_quantity,
                                                                :fire_safety_capacity,
                                                                :fire_safety_date
                                                            )");
                                                            $sql4->bindParam(":site_id",$site_id);
                                                            $sql4->bindParam(":fire_safety_loc_category",$fire_safety_loc_category[$key3]);
                                                            $sql4->bindParam(":fire_safety_location",$fire_safety_location[$key3]);
                                                            $sql4->bindParam(":fire_safety_type",$fire_safety_type[$key3]);
                                                            $sql4->bindParam(":fire_safety_quantity",$fire_safety_quantity[$key3]);
                                                            $sql4->bindParam(":fire_safety_capacity",$fire_safety_capacity[$key3]);
                                                            $sql4->bindParam(":fire_safety_date",$fire_safety_date[$key3]);
                                                            if ($loc_id == 0) {

                                                                $sql4->execute();
                                                            }

                                                        }
                                                    }
                                                }

                                            } 
                                        }

                                } else {

                                    if ($fire_safety_code[$key2] == $fire_safety_category[$key]) {

                                        if (!empty($fire_safety_site[$key2])) {

                                            //SITE INSERT FUNCTION
                                            $sql2 = $pdo->prepare("INSERT INTO operations_audit_tsa_fire_safety_and_security_site (
                                                fire_safety_id,
                                                site,
                                                category
                                            ) VALUES (
                                                :fire_safety_id,
                                                :fire_safety_site,
                                                :fire_safety_site_category
                                            )");
                                            $sql2->bindParam(":fire_safety_id",$safety_id);
                                            $sql2->bindParam(":fire_safety_site",$fire_safety_site[$key2]);
                                            $sql2->bindParam(":fire_safety_site_category",$fire_safety_site_category[$key2]);
                                            if ($site_id == 0) { 
                                                $sql2->execute();

                                                $site_lastinsert_id = $pdo->lastInsertId();

                                                //
                                                if ($fire_safety_code[$key2] == $fire_safety_category[$key]) {

                                                    $fire_safety_location = array();
                                                    if(isset($_POST[$fire_safety_code[$key2].'_location'])) {
                                                        $fire_safety_location = $_POST[$fire_safety_code[$key2].'_location'];
                                                    }

                                                    $fire_safety_type = array();
                                                    if(isset($_POST[$fire_safety_code[$key2].'_type'])) {
                                                        $fire_safety_type = $_POST[$fire_safety_code[$key2].'_type'];
                                                    }

                                                    $fire_safety_quantity = array();
                                                    if(isset($_POST[$fire_safety_code[$key2].'_quantity'])) {
                                                        $fire_safety_quantity = $_POST[$fire_safety_code[$key2].'_quantity'];
                                                    }

                                                    $fire_safety_capacity = array();
                                                    if(isset($_POST[$fire_safety_code[$key2].'_capacity'])) {
                                                        $fire_safety_capacity = $_POST[$fire_safety_code[$key2].'_capacity'];
                                                    }

                                                    $fire_safety_date = array();
                                                    if(isset($_POST[$fire_safety_code[$key2].'_date'])) {
                                                        $fire_safety_date = $_POST[$fire_safety_code[$key2].'_date'];
                                                    }

                                                    $fire_safety_loc_category = array();
                                                    if(isset($_POST[$fire_safety_code[$key2].'_loc_category'])) {
                                                        $fire_safety_loc_category = $_POST[$fire_safety_code[$key2].'_loc_category'];
                                                    }

                                                    $fire_safety_loc_id = array();
                                                    if(isset($_POST[$fire_safety_code[$key2].'_loc_id'])) {
                                                        $fire_safety_loc_id = $_POST[$fire_safety_code[$key2].'_loc_id'];
                                                    }

                                                    foreach ($fire_safety_loc_id as $key3 => $loc_id) {

                                                        // update site location
                                                        $sql3 = $pdo->prepare("SELECT * FROM operations_audit_tsa_fire_safety_and_security_site_location WHERE id = :loc_id AND site_id = :site_id");
                                                        $sql3->bindParam(":loc_id", $loc_id);
                                                        $sql3->bindParam(":site_id", $site_id);
                                                        $sql3->execute();
                                                        if ($sql3->rowcount()) {

                                                            $_data2 = $sql3->fetch(PDO::FETCH_ASSOC);

                                                            //SITE LOCATION UPDATE FUNCTION
                                                            $sql4 = $pdo->prepare("UPDATE operations_audit_tsa_fire_safety_and_security_site_location SET
                                                                location = :fire_safety_location,
                                                                type = :fire_safety_type,
                                                                quantity = :fire_safety_quantity,
                                                                capacity = :fire_safety_capacity,
                                                                date_of_last_refill = :fire_safety_date
                                                            WHERE id = :loc_id AND site_id = :site_id");
                                                            $sql4->bindParam(":loc_id",$loc_id);
                                                            $sql4->bindParam(":site_id",$site_id);
                                                            $sql4->bindParam(":fire_safety_location",$fire_safety_location[$key3]);
                                                            $sql4->bindParam(":fire_safety_type",$fire_safety_type[$key3]);
                                                            $sql4->bindParam(":fire_safety_quantity",$fire_safety_quantity[$key3]);
                                                            $sql4->bindParam(":fire_safety_capacity",$fire_safety_capacity[$key3]);
                                                            $sql4->bindParam(":fire_safety_date",$fire_safety_date[$key3]);
                                                            $sql4->execute();

                                                            
                                                        } else {

                                                            if ($fire_safety_site_category[$key2] == $fire_safety_loc_category[$key3]) {

                                                                if (checkVar($fire_safety_location[$key3])) {

                                                                    //SITE INSERT FUNCTION
                                                                    $sql4 = $pdo->prepare("INSERT INTO operations_audit_tsa_fire_safety_and_security_site_location (
                                                                        site_id,
                                                                        category,
                                                                        location,
                                                                        type,
                                                                        quantity,
                                                                        capacity,
                                                                        date_of_last_refill
                                                                    ) VALUES (
                                                                        :site_id,
                                                                        :fire_safety_loc_category,
                                                                        :fire_safety_location,
                                                                        :fire_safety_type,
                                                                        :fire_safety_quantity,
                                                                        :fire_safety_capacity,
                                                                        :fire_safety_date
                                                                    )");
                                                                    $sql4->bindParam(":site_id",$site_lastinsert_id);
                                                                    $sql4->bindParam(":fire_safety_loc_category",$fire_safety_loc_category[$key3]);
                                                                    $sql4->bindParam(":fire_safety_location",$fire_safety_location[$key3]);
                                                                    $sql4->bindParam(":fire_safety_type",$fire_safety_type[$key3]);
                                                                    $sql4->bindParam(":fire_safety_quantity",$fire_safety_quantity[$key3]);
                                                                    $sql4->bindParam(":fire_safety_capacity",$fire_safety_capacity[$key3]);
                                                                    $sql4->bindParam(":fire_safety_date",$fire_safety_date[$key3]);
                                                                    if ($loc_id == 0) {

                                                                        $sql4->execute();
                                                                    }

                                                                }
                                                            }
                                                        }

                                                    }

                                                }

                                            }

                                        }
                                    }
                                }
                            }
                        }

                    }

        // SECTION 4

            foreach ($sic_id as $key => $sic) {

                // Safety Inspection Checklist UPDATE FUNCTION
                    $sql = $pdo->prepare("UPDATE operations_audit_tsa_safety_inspection_checklist SET
                        status = :sic_check_status,
                        remarks = :sic_remarks
                    WHERE id = :id AND tsa_id = :tsa_id AND particulars = :sic_particulars AND standards = :sic_standards");
                    $sql->bindParam(":id",$sic);
                    $sql->bindParam(":tsa_id",$tsa_id);
                    $sql->bindParam(":sic_standards",$sic_standards[$key]);
                    $sql->bindParam(":sic_particulars",$sic_particulars[$key]);
                    $sql->bindParam(":sic_check_status",$sic_check_status[$key]);
                    $sql->bindParam(":sic_remarks",$sic_remarks[$key]);
                    $sql->execute();
            }

        // SECTION 5

            // Insert into tsa_permit_licences
                foreach($pre_ops_permit_id as $permit_key => $permit_id) { // update

                    $sql1 = $pdo->prepare("UPDATE operations_audit_tsa_permit_licences SET 
                        date_of_issuance = :permit_date_of_issuance,
                        findings = :permit_findings,
                        prioritization = :permit_priority,
                        prioritization_specify = :permit_priority_specify,
                        recommendation = :permit_recommendation
                        WHERE id = :id");
                    $sql1->bindParam(":id", $permit_id);
                    $sql1->bindParam(":permit_date_of_issuance", $permit_date_of_issuance[$permit_key]);
                    $sql1->bindParam(":permit_findings", $permit_findings[$permit_key]);
                    $sql1->bindParam(":permit_priority", $permit_priority[$permit_key]);
                    $sql1->bindParam(":permit_priority_specify", $permit_priority_specify[$permit_key]);
                    $sql1->bindParam(":permit_recommendation", $permit_recommendation[$permit_key]);
                    $sql1->execute();

                }
            //

        // SECTION 6 

            // As-Built Plans INSERT FUNCTION
                foreach ($as_built_id as $key => $ab_value) {

                    // edit
                    $sql = $pdo->prepare("SELECT * FROM operations_audit_tsa_as_built_plans WHERE id = :id AND tsa_id = :tsa_id");
                    $sql->bindParam(":id",$ab_value);
                    $sql->bindParam(":tsa_id", $tsa_id);
                    $sql->execute();
                    if ($sql->rowcount()) {

                        $_data1 = $sql->fetch(PDO::FETCH_ASSOC);

                        $sql1 = $pdo->prepare("UPDATE operations_audit_tsa_as_built_plans SET
                            description = :description, 
                            sheets = :sheets, 
                            recommendation = :as_built_recommendation,
                            findings = :as_built_findings,
                            prioritization = :as_built_priority,
                            prioritization_specify = :as_built_priority_specify 
                        WHERE id = :id");
                        $sql1->bindParam(":id", $ab_value);
                        $sql1->bindParam(":description", $as_built_description[$key]);
                        $sql1->bindParam(":sheets", $sheets[$key]);
                        $sql1->bindParam(":as_built_recommendation", $as_built_recommendation[$key]);
                        $sql1->bindParam(":as_built_findings", $as_built_findings[$key]);
                        $sql1->bindParam(":as_built_priority", $as_built_priority[$key]);
                        $sql1->bindParam(":as_built_priority_specify", $as_built_priority_specify[$key]);
                        $sql1->execute();
                        $sql1->execute();

                    } else {

                        if (checkVar($as_built_description[$key]) || checkVar($sheets[$key]) || checkVar($as_built_recommendation[$key])) {

                            // add
                            $sql1 = $pdo->prepare("INSERT INTO operations_audit_tsa_as_built_plans (
                                tsa_id,
                                description, 
                                sheets, 
                                recommendation,
                                findings,
                                prioritization,
                                prioritization_specify
                            ) VALUES (
                                :tsa_id,
                                :description, 
                                :sheets, 
                                :as_built_recommendation,
                                :as_built_findings,
                                :as_built_priority,
                                :as_built_priority_specify
                            )");
                            $sql1->bindParam(":tsa_id", $tsa_id);
                            $sql1->bindParam(":description", $as_built_description[$key]);
                            $sql1->bindParam(":sheets", $sheets[$key]);
                            $sql1->bindParam(":as_built_recommendation", $as_built_recommendation[$key]);
                            $sql1->bindParam(":as_built_findings", $as_built_findings[$key]);
                            $sql1->bindParam(":as_built_priority", $as_built_priority[$key]);
                            $sql1->bindParam(":as_built_priority_specify", $as_built_priority_specify[$key]);
                            $sql1->execute();
                        }
                        
                    }

                }

            // Equipment Manuals INSERT FUNCTION
                foreach ($manual_equip_id as $key => $equip_value) {

                    //edit
                    $sql = $pdo->prepare("SELECT * FROM operations_audit_tsa_equipment_manuals WHERE id = :id AND tsa_id = :tsa_id");
                    $sql->bindParam(":id",$equip_value);
                    $sql->bindParam(":tsa_id", $tsa_id);
                    $sql->execute();
                    if ($sql->rowcount()) {

                        $_data1 = $sql->fetch(PDO::FETCH_ASSOC);

                        $sql1 = $pdo->prepare("UPDATE operations_audit_tsa_equipment_manuals SET
                            contractor = :contractor, 
                            description = :description, 
                            submitted_documents = :submitted_documents,
                            findings = :manual_findings,
                            prioritization = :manual_priority,
                            prioritization_specify = :manual_priority_specify,
                            recommendation = :manual_recommendation
                            WHERE id = :id");
                        $sql1->bindParam(":id", $equip_value);
                        $sql1->bindParam(":contractor", $manual_contractor[$key]);
                        $sql1->bindParam(":description", $manual_description[$key]);
                        $sql1->bindParam(":submitted_documents", $manual_documents[$key]);
                        $sql1->bindParam(":manual_findings", $manual_findings[$key]);
                        $sql1->bindParam(":manual_priority", $manual_priority[$key]);
                        $sql1->bindParam(":manual_priority_specify", $manual_priority_specify[$key]);
                        $sql1->bindParam(":manual_recommendation", $manual_recommendation[$key]);
                        $sql1->execute();

                    } else {

                        if (checkVar($manual_description[$key]) || checkVar($manual_contractor[$key]) || checkVar($manual_documents[$key]) || checkVar($manual_recommendation[$key])) {

                            $sql1 = $pdo->prepare("INSERT INTO operations_audit_tsa_equipment_manuals (
                                tsa_id, 
                                contractor, 
                                description, 
                                submitted_documents,
                                findings,
                                prioritization,
                                prioritization_specify,
                                recommendation
                            ) VALUES (
                                :tsa_id,  
                                :contractor, 
                                :description, 
                                :submitted_documents,
                                :manual_findings,
                                :manual_priority,
                                :manual_priority_specify,
                                :manual_recommendation
                            )");
                            $sql1->bindParam(":tsa_id", $tsa_id);
                            $sql1->bindParam(":contractor", $manual_contractor[$key]);
                            $sql1->bindParam(":description", $manual_description[$key]);
                            $sql1->bindParam(":submitted_documents", $manual_documents[$key]);
                            $sql1->bindParam(":manual_findings", $manual_findings[$key]);
                            $sql1->bindParam(":manual_priority", $manual_priority[$key]);
                            $sql1->bindParam(":manual_priority_specify", $manual_priority_specify[$key]);
                            $sql1->bindParam(":manual_recommendation", $manual_recommendation[$key]);
                            $sql1->execute();
                        }

                    }
                }

        //
            $_SESSION['sys_operation_audit_tsa_suc'] = renderLang($operation_audit_tsa_added);
            header('location: /operations-audit-tsa-list');

        } else {
            $_SESSION['sys_operation_audit_tsa_err'] = renderLang($form_error);
            header('location: /edit-tsa-operations-audit/'.$tsa_id);
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