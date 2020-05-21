<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

    // check permission to access this page or function
    if(checkPermission('operations-audit-TSA-add')) {

        $err = 0;

        // TSA Data
            $prospect_id = '';
            if(isset($_POST['prospect_id'])) {
                $prospect_id = trim($_POST['prospect_id']);
                if(strlen($prospect_id) == 0) {
                    $err++;
                }
            }

            $property_id = 0;

            $sql = $pdo->prepare("SELECT * FROM properties WHERE prospect_id = :prospect_id");
            $sql->bindParam(":prospect_id",$prospect_id);
            $sql->execute();
            if ($sql->rowCount()) {
                $_data = $sql->fetch(PDO::FETCH_ASSOC);

                $property_id = $_data['property_id'];

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

            // FIRE EXTINGUISHERS AND EMERGENCY LIGHTS

                // fire safety
                    $fire_safety_category = array();
                    if(isset($_POST['fire_safety_category'])) {
                        $fire_safety_category = $_POST['fire_safety_category'];
                    }

                    $fire_safety_details = array();
                    if(isset($_POST['fire_safety_details'])) {
                        $fire_safety_details = $_POST['fire_safety_details'];
                    }

                // site
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

        // Section 4

            // Safety Inspection Checklist

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

            $permit_particulars = array();
            if(isset($_POST['permit_particulars'])) {
                $permit_particulars = $_POST['permit_particulars'];
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
            $sql = $pdo->prepare("INSERT INTO `operations_audit_tsa`(
                prospect_id,
                property_id,
                date_of_audit, 
                date_presented, 
                summary, 
                building_description, 
                building_picture
            ) VALUES (
                :prospect_id,
                :property_id,
                :date_of_audit,
                :date_presented,
                :summary,
                :building_description,
                :building_picture
            )");

            $sql->bindParam("prospect_id", $prospect_id);
            $sql->bindParam("property_id", $property_id);
            $sql->bindParam("date_of_audit", $date_of_audit);
            $sql->bindParam("date_presented", $date_presented);
            $sql->bindParam("summary", $summary);
            $sql->bindParam("building_description", $building_description);

            // building picture
            $attachment_name = '';
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

            $tsa_id = $pdo->lastInsertId();

        // SECTION 3

            # A. Compliances and Non Conformances Item

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
                    foreach ($non_conformances as $key => $non_conformance) {
                        if (!empty($non_conformance) || !empty($nc_status[$key]) || !empty($nc_remarks[$key])) {
                            $sql->bindParam(":non_conformance",$non_conformance);
                            $sql->bindParam(":nc_status",$nc_status[$key]);
                            $sql->bindParam(":nc_remarks",$nc_remarks[$key]);
                            $sql->execute();
                        }
                    }

                // set category
                    foreach ($location_category as $key => $cat) {

                        // system INSERT FUNCTION
                            $sql = $pdo->prepare("INSERT INTO operations_audit_tsa_system (
                                tsa_id,
                                category,
                                details,
                                notes
                            ) VALUES (
                                :tsa_id,
                                :location_category,
                                :location_details,
                                :location_notes
                            )");
                            $sql->bindParam(":tsa_id",$tsa_id);
                            $sql->bindParam(":location_category",$cat);
                            $sql->bindParam(":location_details",$location_details[$key]);
                            $sql->bindParam(":location_notes",$location_notes[$key]);
                            $sql->execute();

                            $system_id = $pdo->lastInsertId();

                        // insert system pictures
                            $sql = $pdo->prepare("INSERT INTO operations_audit_tsa_system_pictures (
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
                            $sql->bindParam(":system_id", $system_id);

                            foreach($picture_code as $key => $code) {

                                if($code == $cat) {

                                    $picture_attach = '';
                                    if(!empty($pictures['name'][$key])) {

                                        if(!is_dir($sys_upload_dir.'operations-audit-tsa-section3')) {
                                            mkdir($sys_upload_dir.'operations-audit-tsa-section3', 0755, true);
                                        }
                        
                                        $file = explode('.', $pictures['name'][$key]);
                                        $file_name = $file[0];
                                        $file_ext = $file[1];
                        
                                        $time = time();
                        
                                        $picture_attach = $file_name.'-TSA-'.$time.'.'.$file_ext;
                        
                                        $file_tmp = $pictures['tmp_name'][$key];
                                        $file_size = $pictures['size'][$key];
                                        
                                        // save file
                                        move_uploaded_file($file_tmp, $sys_upload_dir.'operations-audit-tsa-section3/'.$picture_attach);

                                    }
                                    
                                    $sql->bindParam(":picture", $picture_attach);
                                    $sql->bindParam(":picture_findings", $picture_findings[$key]);
                                    $sql->bindParam(":picture_priority", $picture_priority[$key]);
                                    $sql->bindParam(":picture_priority_specify", $picture_priority_specify[$key]);
                                    $sql->bindParam(":recommendation", $picture_recommendations[$key]);
                                    $sql->execute();

                                }

                            }

                        // insert system_locations
                            $start = 0;
                            $end = 0;
                            foreach($location_code as $key => $code) {

                                if($cat == $code) {

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

                                    $sql1->bindParam(":system_id", $system_id);
                                    $sql1->bindParam(":location", $location[$key]);
                                    $sql1->bindParam(":unit", $location_unit[$key]);
                                    $sql1->bindParam(":findings", $location_findings[$key]);
                                    $sql1->bindParam(":prioritization", $location_priority[$key]);
                                    $sql1->bindParam(":prioritization_specify", $location_priority_specify[$key]);
                                    $sql1->bindParam(":recommendation", $location_recommendation[$key]);
                                    $sql1->execute();

                                    $location_id = $pdo->lastInsertId();

                                    $unit_specification_category = array();
                                    if(isset($_POST[$code.'_specification_category'])) {
                                        $unit_specification_category = $_POST[$code.'_specification_category'];
                                    }

                                    $unit_specification = array();
                                    if(isset($_POST[$code.'_specification'])) {
                                        $unit_specification = $_POST[$code.'_specification'];
                                    }

                                    $unit_data = array();
                                    if(isset($_POST[$code.'_data'])) {
                                        $unit_data = $_POST[$code.'_data'];
                                    }

                                    $num = count($tsa_section_3_arr[$code][1]);
                                    $end += $num;
                                    

                                    foreach($unit_specification_category as $spec_key => $spec) {

                                        // insert system_units
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


                // FIRE EXTINGUISHERs AND EMERGENCY LIGHTS INSERT FUNCTION
                    foreach ($fire_safety_category as $key => $category) {

                        $sql = $pdo->prepare("INSERT INTO operations_audit_tsa_fire_safety_and_security (
                            tsa_id,
                            category,
                            details
                        ) VALUES (
                            :tsa_id,
                            :fire_safety_category,
                            :fire_safety_details
                        )");
                        $sql->bindParam(":tsa_id",$tsa_id);
                        $sql->bindParam(":fire_safety_category",$category);
                        $sql->bindParam(":fire_safety_details",$fire_safety_details[$key]);
                        $sql->execute();

                        $fire_safety_id = $pdo->lastInsertId();

                        foreach ($fire_safety_code as $key2 => $code) {
                            
                            if ($category == $code) {
                                
                                if (checkVar($fire_safety_site[$key2])) {
                            
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
                                    $sql2->bindParam(":fire_safety_id",$fire_safety_id);
                                    $sql2->bindParam(":fire_safety_site",$fire_safety_site[$key2]);
                                    $sql2->bindParam(":fire_safety_site_category",$fire_safety_site_category[$key2]);
                                    $sql2->execute();

                                    $site_id = $pdo->lastInsertId();

                                    $fire_safety_location = array();
                                    if(isset($_POST[$code.'_location'])) {
                                        $fire_safety_location = $_POST[$code.'_location'];
                                    }

                                    $fire_safety_type = array();
                                    if(isset($_POST[$code.'_type'])) {
                                        $fire_safety_type = $_POST[$code.'_type'];
                                    }

                                    $fire_safety_quantity = array();
                                    if(isset($_POST[$code.'_quantity'])) {
                                        $fire_safety_quantity = $_POST[$code.'_quantity'];
                                    }

                                    $fire_safety_capacity = array();
                                    if(isset($_POST[$code.'_capacity'])) {
                                        $fire_safety_capacity = $_POST[$code.'_capacity'];
                                    }

                                    $fire_safety_date = array();
                                    if(isset($_POST[$code.'_date'])) {
                                        $fire_safety_date = $_POST[$code.'_date'];
                                    }

                                    $fire_safety_loc_category = array();
                                    if(isset($_POST[$code.'_loc_category'])) {
                                        $fire_safety_loc_category = $_POST[$code.'_loc_category'];
                                    }

                                        foreach ($fire_safety_loc_category as $key4 => $loc_category) {

                                            if ($loc_category == $fire_safety_site_category[$key2]) {

                                                //SITE INSERT FUNCTION
                                                $sql3 = $pdo->prepare("INSERT INTO operations_audit_tsa_fire_safety_and_security_site_location (
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
                                                $sql3->bindParam(":site_id",$site_id);
                                                $sql3->bindParam(":fire_safety_loc_category",$loc_category);
                                                if (checkVar($fire_safety_location[$key4])) {

                                                    $sql3->bindParam(":fire_safety_location",$fire_safety_location[$key4]);
                                                    $sql3->bindParam(":fire_safety_type",$fire_safety_type[$key4]);
                                                    $sql3->bindParam(":fire_safety_quantity",$fire_safety_quantity[$key4]);
                                                    $sql3->bindParam(":fire_safety_capacity",$fire_safety_capacity[$key4]);
                                                    $sql3->bindParam(":fire_safety_date",$fire_safety_date[$key4]);
                                                    $sql3->execute();
                                                }
                                            }
                                        }
                                }
                            }
                        }
                    }

        // SECTION 4

            // Safety Inspection Checklist INSERT FUNCTION
                $sql = $pdo->prepare("INSERT INTO operations_audit_tsa_safety_inspection_checklist (
                    tsa_id,
                    particulars,
                    standards,
                    status,
                    remarks
                ) VALUES (
                    :tsa_id,
                    :sic_particulars,
                    :sic_standards,
                    :sic_check_status,
                    :sic_remarks
                )");
                $sql->bindParam(":tsa_id",$tsa_id);
                foreach ($sic_standards as $key => $standards) {
                    $sql->bindParam(":sic_standards",$standards);
                    $sql->bindParam(":sic_particulars",$sic_particulars[$key]);
                    $sql->bindParam(":sic_check_status",$sic_check_status[$key]);
                    $sql->bindParam(":sic_remarks",$sic_remarks[$key]);
                    $sql->execute();
                }

        // SECTION 5
                foreach($permit_particulars as $key => $particular) {

                    $sql = $pdo->prepare("INSERT INTO operations_audit_tsa_permit_licences (
                        tsa_id, 
                        particulars, 
                        date_of_issuance,
                        findings,
                        prioritization,
                        prioritization_specify,
                        recommendation
                    ) VALUES (
                        :tsa_id,
                        :particular, 
                        :permit_date_of_issuance,
                        :permit_findings,
                        :permit_priority,
                        :permit_priority_specify,
                        :permit_recommendation
                    )");

                    $sql->bindParam(":tsa_id", $tsa_id);
                    $sql->bindParam(":particular", $particular);
                    $sql->bindParam(":permit_date_of_issuance", $permit_date_of_issuance[$key]);
                    $sql->bindParam(":permit_findings", $permit_findings[$key]);
                    $sql->bindParam(":permit_priority", $permit_priority[$key]);
                    $sql->bindParam(":permit_priority_specify", $permit_priority_specify[$key]);
                    $sql->bindParam(":permit_recommendation", $permit_recommendation[$key]);
                    $sql->execute();

                }
            
        // SECTION 6 

            // As-Built Plans INSERT FUNCTION
                $sql = $pdo->prepare("INSERT INTO operations_audit_tsa_as_built_plans (
                    tsa_id,
                    description,
                    sheets,
                    recommendation,
                    findings,
                    prioritization,
                    prioritization_specify
                ) VALUES (
                    :tsa_id,
                    :as_built_description,
                    :sheets,
                    :as_built_recommendation,
                    :as_built_findings,
                    :as_built_priority,
                    :as_built_priority_specify
                )");
                $sql->bindParam(":tsa_id",$tsa_id);
                foreach ($as_built_description as $key => $description) {
                    if (!empty($description) || !empty($sheets[$key]) || !empty($as_built_remarks[$key])) {
                        $sql->bindParam(":as_built_description",$description);
                        $sql->bindParam(":sheets",$sheets[$key]);
                        $sql->bindParam(":as_built_recommendation", $as_built_recommendation[$key]);
                        $sql->bindParam(":as_built_findings", $as_built_findings[$key]);
                        $sql->bindParam(":as_built_priority", $as_built_priority[$key]);
                        $sql->bindParam(":as_built_priority_specify", $as_built_priority_specify[$key]);
                        $sql->execute();
                    }
                }

            // Equipment Manuals INSERT FUNCTION
                $sql = $pdo->prepare("INSERT INTO operations_audit_tsa_equipment_manuals (
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
                    :manual_contractor,
                    :manual_description,
                    :manual_documents,
                    :manual_findings,
                    :manual_priority,
                    :manual_priority_specify,
                    :manual_recommendation
                )");
                $sql->bindParam(":tsa_id",$tsa_id);
                foreach ($manual_description as $key => $description) {
                    if (!empty($description) || !empty($manual_contractor[$key]) || !empty($manual_documents[$key])) {
                        $sql->bindParam(":manual_description",$description);
                        $sql->bindParam(":manual_contractor",$manual_contractor[$key]);
                        $sql->bindParam(":manual_documents",$manual_documents[$key]);
                        $sql->bindParam(":manual_findings", $manual_findings[$key]);
                        $sql->bindParam(":manual_priority", $manual_priority[$key]);
                        $sql->bindParam(":manual_priority_specify", $manual_priority_specify[$key]);
                        $sql->bindParam(":manual_recommendation", $manual_recommendation[$key]);
                        $sql->execute();
                    }
                }
  
        //
            $_SESSION['sys_operation_audit_tsa_suc'] = renderLang($operation_audit_tsa_added);
            header('location: /operations-audit-tsa-list');

        } else {
            $_SESSION['sys_operation_audit_tsa_err'] = renderLang($form_error);
            header('location: /add-tsa-operations-audit');
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