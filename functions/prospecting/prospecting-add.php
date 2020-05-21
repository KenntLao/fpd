<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('prospecting-add')) {
	
		$err = 0;

		$prospecting_category = $_POST['prospecting_category'];
		
		// PROCESS FORM

		// REFERENCE NUMBER
		$reference_number = '';
		if(isset($_POST['reference_number'])) {
			$reference_number = trim($_POST['reference_number']);
			if(strlen($reference_number) == 0) {
				$err++;
				$_SESSION['sys_prospecting_add_reference_number_err'] = renderLang($prospecting_reference_number_required);
			} else {
				
				$_SESSION['sys_prospecting_add_reference_number_val'] = $reference_number;
				
				// check if client ID already exists
				$sql = $pdo->prepare("SELECT reference_number, temp_del FROM prospecting WHERE reference_number = :reference_number AND temp_del = 0 LIMIT 1");
				$sql->bindParam(":reference_number",$reference_number);
				$sql->execute();
				if($sql->rowCount()) {
					$err++;
					$_SESSION['sys_prospecting_add_reference_number_err'] = renderLang($prospecting_reference_number_exists);
				}
			}
		}
		
		// PROJECT NAME
		$project_name = '';
		if(isset($_POST['project_name'])) {
			$project_name = trim($_POST['project_name']);
			$_SESSION['sys_prospecting_add_project_name_val'] = $project_name;
			
		}

		// OWNER/DEVELOPER
		$owner_developer = '';
		if(isset($_POST['owner_developer'])) {
			$owner_developer = trim($_POST['owner_developer']);
			$_SESSION['sys_prospecting_add_owner_developer_val'] = $owner_developer;
		}
		
		// LOCATION
		$location = '';
		if(isset($_POST['location'])) {
			$location = trim($_POST['location']);
			$_SESSION['sys_prospecting_add_location_val'] = $location;
		}

		// PROPERTY CATEGORY
		$property_category = '';
		if(isset($_POST['property_category'])) {
			$property_category = trim($_POST['property_category']);
			$_SESSION['sys_prospecting_add_property_category_val'] = $property_category;
		}

		// PROPERTY CATEGORY OTHER
		$property_category_others = '';
		if(isset($_POST['property_category_others'])) {
			$property_category_others = trim($_POST['property_category_others']);
		}

		// NUMBER OF BUILDING
		$number_of_building = '';
		if(isset($_POST['number_of_building'])) {
			$number_of_building = trim($_POST['number_of_building']);
			$_SESSION['sys_prospecting_add_number_of_building_val'] = $number_of_building;
		}

		// PROPERTY AGE
		$property_age = 0;
		if(isset($_POST['property_age'])) {
			$property_age = trim($_POST['property_age']);
			$_SESSION['sys_prospecting_add_property_age_val'] = $property_age;
		}

		// SERVICE REQUIRED
		$service_required = '';
		if(isset($_POST['service_required'])) {
			$service_required = trim($_POST['service_required']);
			$_SESSION['sys_prospecting_add_service_required_val'] = $service_required;
		}

		// OTHER SERVICES
		$other_services = '';
		if(isset($_POST['other_services'])) {
			$other_services = trim($_POST['other_services']);
			$_SESSION['sys_prospecting_add_other_services_val'] = $other_services;
		}

		// CURRENT PM
		$current_property_management = '';
		if(isset($_POST['current_property_management'])) {
			$current_property_management = trim($_POST['current_property_management']);
			$_SESSION['sys_prospecting_add_current_property_management_val'] = $current_property_management;
        }
        
        // PROSPECT CONTACT
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

		//  REMARKS ON CONTACT PERSON
		$remarks_on_contact_person = '';
		if(isset($_POST['remarks_on_contact_person'])) {
			$remarks_on_contact_person = trim($_POST['remarks_on_contact_person']);
			$_SESSION['sys_prospecting_add_remarks_on_contact_person_val'] = $remarks_on_contact_person;
		}

		// REFERRED BY
		$referred_by = '';
		if(isset($_POST['referred_by'])) {
			$referred_by = trim($_POST['referred_by']);
			$_SESSION['sys_prospecting_add_referred_by_val'] = $referred_by;
		}

		// LEAD RECEIVED THROUGH
		$lead_received_through = '';
		if(isset($_POST['lead_received_through'])) {
			$lead_received_through = trim($_POST['lead_received_through']);
			$_SESSION['sys_prospecting_add_lead_received_through_val'] = $lead_received_through;
		}

		// OTHER LEAD REMARKS
		$other_lead_remarks = '';
		if(isset($_POST['other_lead_remarks'])) {
			$other_lead_remarks = trim($_POST['other_lead_remarks']);
			$_SESSION['sys_prospecting_add_other_lead_remarks_val'] = $other_lead_remarks;
		}
		
		
		// VALIDATE FOR ERRORS
		if($err == 0) { // there are no errors

            $curr_date = time();
      
			$sql = $pdo->prepare("INSERT INTO prospecting (
				reference_number,
				project_name,
				owner_developer,
				location,
				property_category,
				property_category_others,
				number_of_building,
				property_age,
				service_required,
				other_services,
				current_property_management,
				remarks_on_contact_person,
				referred_by,
				lead_received_through,
				other_lead_remarks,
				date,
				created_by,
				account_mode,
				prospecting_category,
                contact_person, 
                designation, 
                mobile_number, 
                email_address
			) VALUES (
				:reference_number,
				:project_name,
				:owner_developer,
				:location,
				:property_category,
				:property_category_others,
				:number_of_building,
				:property_age,
				:service_required,
				:other_services,
				:current_property_management,
				:remarks_on_contact_person,
				:referred_by,
				:lead_received_through,
				:other_lead_remarks,
				:date,
				:user_id,
				:account_mode,
				:prospecting_category,
                :contact_person, 
                :designation, 
                :mobile_number, 
                :email_address
			)");
			$sql->bindParam(":reference_number", $reference_number);
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
			$sql->bindParam(":date", $curr_date);
			$sql->bindParam(":user_id", $_SESSION['sys_id']);
			$sql->bindParam(":account_mode", $_SESSION['sys_account_mode']);
            $sql->bindParam(":prospecting_category", $prospecting_category);
            $sql->bindParam(":contact_person", $prospect_contact_person);
            $sql->bindParam(":designation", $prospect_contact_designation);
            $sql->bindParam(":mobile_number", $prospect_contact_number);
            $sql->bindParam(":email_address", $prospect_email_address);
			$sql->execute();

			$id = $pdo->lastInsertId();
			
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

			$code = $id.'1';

			foreach ($contact_person as $key => $contact) {

                if(!empty($contact)) {

                    $sql2->bindParam(":contact_person", $contact);
                    $sql2->bindParam(":contact_number", $contact_number[$key]);
                    $sql2->bindParam(":designation", $designation[$key]);
                    $sql2->bindParam(":email_address", $email_address[$key]);
                    $sql2->bindParam(":code", $code);
                    $sql2->execute();

                    $code++;
                }

			}
			
            systemLog('prospecting',$id ,'add', '');
            
            // notifications
            $employees = getTable('employees');
            $users = getTable('users');
            foreach($employees as $employee) {
                push_notification('prospecting', $id, $employee['id'], 'employee', 'prospecting_add');
            }

            foreach($users as $user) {
                push_notification('prospecting', $id, $user['id'], 'user', 'prospecting_add');
            }

			$sql3 = $pdo->prepare("SELECT * FROM prospecting WHERE id = :id LIMIT 1");
			$sql3 ->bindParam(":id", $id);
			$sql3->execute();
			$_data = $sql3->fetch(PDO::FETCH_ASSOC);

			$_SESSION['sys_prospecting_add_suc'] = renderLang($prospecting_added);
			header('location: /prospecting-list/'.$_data['prospecting_category']);
			
		} else { // error found
			
			$_SESSION['sys_prospecting_add_err'] = renderLang($form_error);
			header('location: /add-prospecting-'.$_data['property_category']);
			
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