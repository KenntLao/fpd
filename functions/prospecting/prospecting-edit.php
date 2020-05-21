<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('prospecting-edit')) {
	
		$err = 0;
		$id = $_POST['id'];

		// check if exist
        $sql = $pdo->prepare("SELECT * FROM prospecting WHERE id = :id AND temp_del = 0 LIMIT 1");
        $sql->bindParam(":id", $id);
        $sql->execute();
        $_data = $sql->fetch(PDO::FETCH_ASSOC);
        if(!$sql->rowCount()) {
            $err++;
        }
		
		// PROCESS FORM

		// STATUS
		$status = '';
        if(isset($_POST['status'])) {
            $status = trim($_POST['status']);
            $_SESSION['sys_prospecting_edit_status_val'] = $status;
        }

        $declined_remarks = '';
        if($status == 2 || $status == 4) {
            if(isset($_POST['declined_remarks'])) {
                $declined_remarks = trim($_POST['declined_remarks']);
            }
        } else {
            $declined_remarks = getField('declined_remarks', 'prospecting', 'id = '.$id);
        }
		
		
		// PROJECT NAME
		$project_name = '';
		if(isset($_POST['project_name'])) {
			$project_name = trim($_POST['project_name']);
			$_SESSION['sys_prospecting_edit_project_name_val'] = $project_name;
			
		}

		// OWNER/DEVELOPER
		$owner_developer = '';
		if(isset($_POST['owner_developer'])) {
			$owner_developer = trim($_POST['owner_developer']);
			$_SESSION['sys_prospecting_edit_owner_developer_val'] = $owner_developer;
		}
		
		// LOCATION
		$location = '';
		if(isset($_POST['location'])) {
			$location = trim($_POST['location']);
			$_SESSION['sys_prospecting_edit_location_val'] = $location;
		}

		// PROPERTY CATEGORY
		$property_category = '';
		if(isset($_POST['property_category'])) {
			$property_category = trim($_POST['property_category']);
			$_SESSION['sys_prospecting_edit_property_category_val'] = $property_category;
		}

		// PROPERTY CATEGORY
		$property_category_others = '';
		if(isset($_POST['property_category_others'])) {
			$property_category_others = trim($_POST['property_category_others']);
			$_SESSION['sys_prospecting_edit_property_category_others_val'] = $property_category_others;
		}

		// NUMBER OF BUILDING
		$number_of_building = '';
		if(isset($_POST['number_of_building'])) {
			$number_of_building = trim($_POST['number_of_building']);
			$_SESSION['sys_prospecting_edit_number_of_building_val'] = $number_of_building;
		}

		// PROPERTY AGE
		$property_age = 0;
		if(isset($_POST['property_age'])) {
			$property_age = trim($_POST['property_age']);
			$_SESSION['sys_prospecting_edit_property_age_val'] = $property_age;
		}

		// SERVICE REQUIRED
		$service_required = '';
		if(isset($_POST['service_required'])) {
			$service_required = trim($_POST['service_required']);
			$_SESSION['sys_prospecting_edit_service_required_val'] = $service_required;
		}

		// OTHER SERVICES
		$other_services = '';
		if(isset($_POST['other_services'])) {
			$other_services = trim($_POST['other_services']);
			$_SESSION['sys_prospecting_edit_other_services_val'] = $other_services;
		}

		// CURRENT PM
		$current_property_management = '';
		if(isset($_POST['current_property_management'])) {
			$current_property_management = trim($_POST['current_property_management']);
			$_SESSION['sys_prospecting_edit_current_property_management_val'] = $current_property_management;
        }
        
        // PROSPECT CONTACT

        // CONTACT ID
        $contact_id = array();
        if(isset($_POST['prospect_contact_id'])) {
            $contact_id = $_POST['prospect_contact_id'];
        }

        // CONTACT PERSON
		$prospect_contact_person = array();
		if(isset($_POST['prospect_contact_person'])) {
			$prospect_contact_person = $_POST['prospect_contact_person'];
		}

		// DESIGNATION
		$prospect_contact_designation = array();
		if(isset($_POST['prospect_contact_designation'])) {
			$prospect_contact_designation = $_POST['prospect_contact_designation'];
		}

		// CONTACT NUMBER
		$prospect_contact_number = array();
		if(isset($_POST['prospect_contact_number'])) {
			$prospect_contact_number = $_POST['prospect_contact_number'];
		}

		// EMAIL ADDRESS
		$prospect_email_address = array();
		if(isset($_POST['prospect_email_address'])) {
			$prospect_email_address = $_POST['prospect_email_address'];
		}
        // 

		// CONTACT PERSON
		$contact_person = array();
		if(isset($_POST['contact_person'])) {
			$contact_person = $_POST['contact_person'];
		}

		// DESIGNATION
		$designation = array();
		if(isset($_POST['designation'])) {
			$designation = $_POST['designation'];
		}

		// CONTACT NUMBER
		$contact_number = array();
		if(isset($_POST['contact_number'])) {
			$contact_number = $_POST['contact_number'];
		}

		// EMAIL ADDRESS
		$email_address = array();
		if(isset($_POST['email_address'])) {
            $email_address = $_POST['email_address'];
        }

		// CODE
        $code = array();
        if(isset($_POST['code'])) {
            $code = $_POST['code'];
        }

		//  REMARKS ON CONTACT PERSON
		$remarks_on_contact_person = '';
		if(isset($_POST['remarks_on_contact_person'])) {
			$remarks_on_contact_person = trim($_POST['remarks_on_contact_person']);
			$_SESSION['sys_prospecting_edit_remarks_on_contact_person_val'] = $remarks_on_contact_person;
		}

		// REFERRED BY
		$referred_by = '';
		if(isset($_POST['referred_by'])) {
			$referred_by = trim($_POST['referred_by']);
			$_SESSION['sys_prospecting_edit_referred_by_val'] = $referred_by;
		}

		// LEAD RECEIVED THROUGH
		$lead_received_through = '';
		if(isset($_POST['lead_received_through'])) {
			$lead_received_through = trim($_POST['lead_received_through']);
			$_SESSION['sys_prospecting_edit_lead_received_through_val'] = $lead_received_through;
		}

        // OTHER LEAD REMARKS
        $other_lead_remarks = '';
        if(isset($_POST['other_lead_remarks'])) {
            $other_lead_remarks = trim($_POST['other_lead_remarks']);
            $_SESSION['sys_prospecting_edit_other_lead_remarks_val'] = $other_lead_remarks;
        }
		
		// VALIDATE FOR ERRORS
		if($err == 0) { // there are no errors

			$change_logs = array();
			if ($status != $_data['status']) {
				$tmp = 'prospecting_status::'.$_data['status'].'=='.$status;
				array_push($change_logs, $tmp);
			}
			if ($project_name != $_data['project_name']) {
				$tmp = 'prospecting_project_name::'.$_data['project_name'].'=='.$project_name;
				array_push($change_logs, $tmp);
			}
			if ($owner_developer != $_data['owner_developer']) {
				$tmp = 'prospecting_owner_developer::'.$_data['owner_developer'].'=='.$owner_developer;
				array_push($change_logs, $tmp);
			}
			if ($location != $_data['location']) {
				$tmp = 'prospecting_location::'.$_data['location'].'=='.$location;
				array_push($change_logs, $tmp);
			}
			if ($property_category != $_data['property_category']) {
				$tmp = 'prospecting_property_category::'.$_data['property_category'].'=='.$property_category;
				array_push($change_logs, $tmp);
			}
			if ($property_category_others != $_data['property_category_others']) {
				$tmp = 'prospecting_property_category_others::'.$_data['property_category_others'].'=='.$property_category_others;
				array_push($change_logs, $tmp);
			}
			if ($number_of_building  != $_data['number_of_building']) {
				$tmp = 'prospecting_number_of_building::'.$_data['number_of_building'].'=='.$number_of_building;
				array_push($change_logs, $tmp);
			}
			if ($property_age != $_data['property_age']) {
				$tmp = 'prospecting_property_age::'.$_data['property_age'].'=='.$property_age;
				array_push($change_logs, $tmp);
			}
			if ($service_required != $_data['service_required']) {
				$tmp = 'prospecting_service_required::'.$_data['service_required'].'=='.$service_required;
				array_push($change_logs, $tmp);
			}
			if ($other_services != $_data['other_services']) {
				$tmp = 'prospecting_other_services::'.$_data['other_services'].'=='.$other_services;
				array_push($change_logs, $tmp);
			}
			if ($current_property_management != $_data['current_property_management']) {
				$tmp = 'prospecting_current_property_management::'.$_data['current_property_management'].'=='.$current_property_management;
				array_push($change_logs, $tmp);
			}
			if ($remarks_on_contact_person != $_data['remarks_on_contact_person']) {
				$tmp = 'prospecting_remarks_on_contact_person::'.$_data['remarks_on_contact_person'].'=='.$remarks_on_contact_person;
				array_push($change_logs, $tmp);
			}
			if ($referred_by != $_data['referred_by']) {
				$tmp = 'prospecting_referred_by::'.$_data['referred_by'].'=='.$referred_by;
				array_push($change_logs, $tmp);
			}
			if ($lead_received_through != $_data['lead_received_through']) {
				$tmp = 'prospecting_lead_received_through::'.$_data['lead_received_through'].'=='.$lead_received_through;
				array_push($change_logs, $tmp);
			}
			if ($other_lead_remarks != $_data['other_lead_remarks']) {
				$tmp = 'prospecting_other_lead_remarks::'.$_data['other_lead_remarks'].'=='.$other_lead_remarks;
				array_push($change_logs, $tmp);
			}
			if ($declined_remarks != $_data['declined_remarks']) {
				$tmp = 'prospecting_declined_remarks::'.$_data['declined_remarks'].'=='.$declined_remarks;
				array_push($change_logs, $tmp);
			}
			if ($prospect_contact_person != $_data['contact_person']) {
				$tmp = 'prospecting_contact_person::'.$_data['contact_person'].'=='.$prospect_contact_person;
				array_push($change_logs, $tmp);
			}
			if ($prospect_contact_designation != $_data['designation']) {
				$tmp = 'prospecting_designation::'.$_data['designation'].'=='.$prospect_contact_designation;
				array_push($change_logs, $tmp);
			}
			if ($prospect_contact_number != $_data['mobile_number']) {
				$tmp = 'prospecting_contact_number::'.$_data['mobile_number'].'=='.$prospect_contact_number;
				array_push($change_logs, $tmp);
			}
			if ($prospect_email_address != $_data['email_address']) {
				$tmp = 'prospecting_email_address::'.$_data['email_address'].'=='.$prospect_email_address;
				array_push($change_logs, $tmp);
			}
	      
            $sql = $pdo->prepare("UPDATE prospecting SET
                status = :status,
                project_name = :project_name,
                owner_developer = :owner_developer,
                location = :location,
                property_category = :property_category,
                property_category_others = :property_category_others,
                number_of_building = :number_of_building,
                property_age = :property_age,
                service_required = :service_required,
                other_services = :other_services,
                current_property_management = :current_property_management,
                remarks_on_contact_person = :remarks_on_contact_person,
                referred_by = :referred_by,
                lead_received_through = :lead_received_through,
                other_lead_remarks = :other_lead_remarks,
                declined_remarks = :declined_remarks,
                contact_person = :contact_person, 
                designation = :designation, 
                mobile_number = :mobile_number, 
                email_address = :email_address
                WHERE id = :id");
            $sql->bindParam(":status",$status);
            $sql->bindParam(":project_name", $project_name);
            $sql->bindParam(":owner_developer", $owner_developer);
            $sql->bindParam(":location", $location);
            $sql->bindParam(":property_category", $property_category);
            $sql->bindParam(":property_category_others", $property_category_others);
            $sql->bindParam(":number_of_building", $number_of_building);
            $sql->bindParam(":property_age", $property_age);
            $sql->bindParam(":service_required", $service_required);
            $sql->bindParam(":other_services", $other_services);
            $sql->bindParam(":current_property_management", $current_property_management);
            $sql->bindParam(":remarks_on_contact_person", $remarks_on_contact_person);
            $sql->bindParam(":referred_by", $referred_by);
            $sql->bindParam(":lead_received_through", $lead_received_through);
            $sql->bindParam(":other_lead_remarks", $other_lead_remarks);
            $sql->bindParam(":declined_remarks", $declined_remarks);
            $sql->bindParam(":contact_person", $prospect_contact_person);
            $sql->bindParam(":designation", $prospect_contact_designation);
            $sql->bindParam(":mobile_number", $prospect_contact_number);
            $sql->bindParam(":email_address", $prospect_email_address);
            $sql->bindParam(":id", $id);
            $sql->execute();

            foreach($contact_id as $key => $contact) {
                $sql = $pdo->prepare("SELECT * FROM prospecting_contacts WHERE id = :id");
                $sql->bindParam(":id", $contact);
                $sql->execute();
                if($sql->rowCount()) { // update

                    $data = $sql->fetch(PDO::FETCH_ASSOC);

                    if ($contact_person[$key] != $data['contact_person']) {
                        $tmp = 'prospecting_contact_person::'.$data['contact_person'].'=='.$contact_person[$key];
                        array_push($change_logs, $tmp);
                    }
                    if ($contact_number[$key] != $data['contact_number']) {
                        $tmp = 'prospecting_contact_number::'.$data['contact_number'].'=='.$contact_number[$key];
                        array_push($change_logs, $tmp);
                    }
                    if ($designation[$key] != $data['designation']) {
                        $tmp = 'prospecting_designation::'.$data['designation'].'=='.$designation[$key];
                        array_push($change_logs, $tmp);
                    }
                    if ($email_address[$key] != $data['email_address']) {
                        $tmp = 'prospecting_email_address::'.$data['email_address'].'=='.$email_address[$key];
                        array_push($change_logs, $tmp);
                    }

                    if (!empty($contact_person[$key])) {

                        $sql2 = $pdo->prepare("UPDATE prospecting_contacts SET 
                            contact_person = :contact_person,
                            designation = :designation,
                            contact_number = :contact_number,
                            email_address = :email_address
                        WHERE id = :id");
                        $sql2->bindParam(":contact_person", $contact_person[$key]);
                        $sql2->bindParam(":contact_number", $contact_number[$key]);
                        $sql2->bindParam(":designation", $designation[$key]);
                        $sql2->bindParam(":email_address", $email_address[$key]);
                        $sql2->bindParam(":id", $data['id']);
                        $sql2->execute();
                    }

                } else { // insert

                    if(!empty($contact_person[$key])) {
                        
                        $sql2 = $pdo->prepare("INSERT INTO prospecting_contacts (
                            prospect_id,
                            contact_person,
                            contact_number,
                            designation,
                            email_address,
                            code
                        ) VALUES (
                            :prospect_id,
                            :contact_person,
                            :contact_number,
                            :designation,
                            :email_address,
                            :code
                        )");
                        $sql2->bindParam(":prospect_id", $id);
                        $sql2->bindParam(":contact_person", $contact_person[$key]);
                        $sql2->bindParam(":contact_number", $contact_number[$key]);
                        $sql2->bindParam(":designation", $designation[$key]);
                        $sql2->bindParam(":email_address", $email_address[$key]);
                        $sql2->bindParam(":code", $code[$key]);
                        $sql2->execute();
                    }

                }
            }
            
            // record to system log
            if(!empty($change_logs)) {
                $change_log = implode(';;',$change_logs);
                systemLog('prospecting',$id,'update',$change_log);
            }

			// notification update PROSPECTING
			$employees = getTable('employees');
			$users = getTable('users');
            foreach ($employees as $employee) {
                push_notification('prospecting', $id, $employee['id'], 'employee', 'prospecting_updated');
            }
            foreach ($users as $user) {
                push_notification('prospecting', $id, $user['id'], 'user', 'prospecting_updated');
            }

			$sql2 = $pdo->prepare("SELECT * FROM prospecting WHERE id = :id LIMIT 1");
			$sql2 ->bindParam(":id", $id);
			$sql2->execute();
			$_data = $sql2->fetch(PDO::FETCH_ASSOC);

			$_SESSION['sys_prospecting_edit_suc'] = renderLang($prospecting_updated);
			header('location: /prospecting-list/'.$_data['prospecting_category']);
			
		} else { // error found
			
			$_SESSION['sys_prospecting_edit_err'] = renderLang($form_error);
			header('location: /edit-prospecting/'.$id);
			
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