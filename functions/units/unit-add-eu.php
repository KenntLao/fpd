<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('unit-add')) {
	
		$err = 0;

		$date_from = time();
		
		$sql = $pdo->prepare("SELECT unit_owner_id FROM unit_owners ORDER BY id DESC LIMIT 1");
		$sql->execute();
		if($sql->rowCount()) {
			$_data = $sql->fetch(PDO::FETCH_ASSOC);
			$id_suggestion = $_data['unit_owner_id'] + 1;
		} else {
			$id_suggestion = 1001;
		}
		
		// UNIT OWNERS

            // FIRST NAME
            $firstname = '';
            if(isset($_POST['firstname_uo'])) {
                $firstname = trim($_POST['firstname_uo']);
                $_SESSION['sys_unit_eu_add_firstname_uo_val'] = $firstname;
                
            }
            
            // MIDDLE NAME
            $middlename = '';
            if(isset($_POST['middlename_uo'])) {
                $middlename = trim($_POST['middlename_uo']);
                $_SESSION['sys_unit_eu_add_middlename_uo_val'] = $middlename;
                
            }

            // LAST NAME
            $lastname = '';
            if(isset($_POST['lastname_uo'])) {
                $lastname = trim($_POST['lastname_uo']);
                $_SESSION['sys_unit_eu_add_lastname_uo_val'] = $lastname;
                
            }

            // GENDER
            $gender = '';
            if(isset($_POST['gender_uo'])) {
                $gender = trim($_POST['gender_uo']);
                $_SESSION['sys_unit_eu_add_gender_uo_val'] = $gender;
                
            }
            
            // BIRTHDATE
            $birthdate = '';
            if(isset($_POST['birthdate_uo'])) {
                $birthdate = trim($_POST['birthdate_uo']);
                $_SESSION['sys_unit_eu_add_birthdate_uo_val'] = $birthdate;
                
            }

            // CITIZENSHIP
            $citizenship_id = '';
            if(isset($_POST['citizenship_id_uo'])) {
                $citizenship_id = trim($_POST['citizenship_id_uo']);
                $_SESSION['sys_unit_eu_add_citizenship_id_uo_val'] = $citizenship_id;
                
            }

            $unit_owner_parking = '';
            if(isset($_POST['unit_owner_parking'])) {
                $unit_owner_parking = trim($_POST['unit_owner_parking']);
            }
        // 

		// UNITS

            // UNIT NAME
            $unit_name = '';
            if(isset($_POST['unit_name'])) {
                $unit_name = trim($_POST['unit_name']);
                $_SESSION['sys_unit_eu_add_unit_name_val'] = $unit_name;
                
            }

            // BUILDING
            $sub_property_id = '';
            if(isset($_POST['sub_property_id'])) {
                $sub_property_id = trim($_POST['sub_property_id']);
                $_SESSION['sys_unit_eu_add_sub_property_id_val'] = $sub_property_id;
                
            }

            // PROPERTY
            $property_id = '';
            if(isset($_POST['property_id'])) {
                $property_id = trim($_POST['property_id']);
                $_SESSION['sys_unit_eu_add_property_id_val'] = $property_id;
                
            }

            // UNIT CAPACITY
            $unit_capacity = '';
            if(isset($_POST['unit_capacity'])) {
                $unit_capacity = trim($_POST['unit_capacity']);
                $_SESSION['sys_unit_eu_add_unit_capacity_val'] = $unit_capacity;
                
            }

            // UNIT TYPE
            $unit_type = '';
            if(isset($_POST['unit_type'])) {
                $unit_type = trim($_POST['unit_type']);
                $_SESSION['sys_unit_eu_add_unit_type_val'] = $unit_type;
                
            }
            // UNIT AREA
            $unit_area = '';
            if(isset($_POST['unit_area'])) {
                $unit_area = trim($_POST['unit_area']);
                $_SESSION['sys_unit_eu_add_unit_area_val'] = $unit_area;
                
            }
        // 

		// TENANTS

            // FIRST NAME
            $tenants_firstname = array();
            if(isset($_POST['tenants_firstname'])) {
                $tenants_firstname = $_POST['tenants_firstname'];
                
            }
            
            // MIDDLE NAME
            $tenants_middlename = array();
            if(isset($_POST['tenants_middlename'])) {
                $tenants_middlename = $_POST['tenants_middlename'];
                
            }

            // LAST NAME
            $tenants_lastname = array();
            if(isset($_POST['tenants_lastname'])) {
                $tenants_lastname = $_POST['tenants_lastname'];
                
            }

            // GENDER
            $tenants_gender = array();
            if(isset($_POST['tenants_gender'])) {
                $tenants_gender = $_POST['tenants_gender'];
                
            }
            
            // BIRTHDATE
            $tenants_birthdate = array();
            if(isset($_POST['tenants_birthdate'])) {
                $tenants_birthdate = $_POST['tenants_birthdate'];
                
            }

            // CITIZENSHIP
            $tenants_citizenship_id = array();
            if(isset($_POST['tenants_citizenship_id'])) {
                $tenants_citizenship_id = $_POST['tenants_citizenship_id'];
                
            }

            // RELATIONSHIP TO OWNER
            $tenants_relationship_to_owner = array();
            if(isset($_POST['tenants_relationship_to_owner'])) {
                $tenants_relationship_to_owner = $_POST['tenants_relationship_to_owner'];
                
            }

            // SOCIAL STATUS
            $tenants_social_status = array();
            if(isset($_POST['tenants_social_status'])) {
                $tenants_social_status = $_POST['tenants_social_status'];
                
            }

            // PARKING
            $tenant_parking = array();
            if(isset($_POST['tenant_parking'])) {
                $tenant_parking = $_POST['tenant_parking'];
            }
        // 

		// OCCUPANTS

            // FIRST NAME
            $occupants_firstname = array();
            if(isset($_POST['occupants_firstname'])) {
                $occupants_firstname = $_POST['occupants_firstname'];
                
            }
            
            // MIDDLE NAME
            $occupants_middlename = array();
            if(isset($_POST['occupants_middlename'])) {
                $occupants_middlename = $_POST['occupants_middlename'];
                
            }

            // LAST NAME
            $occupants_lastname = array();
            if(isset($_POST['occupants_lastname'])) {
                $occupants_lastname = $_POST['occupants_lastname'];
                
            }

            // GENDER
            $occupants_gender = array();
            if(isset($_POST['occupants_gender'])) {
                $occupants_gender = $_POST['occupants_gender'];
                
            }
            
            // BIRTHDATE
            $occupants_birthdate = array();
            if(isset($_POST['occupants_birthdate'])) {
                $occupants_birthdate = $_POST['occupants_birthdate'];
                
            }

            // CITIZENSHIP
            $occupants_citizenship_id = array();
            if(isset($_POST['occupants_citizenship_id'])) {
                $occupants_citizenship_id = $_POST['occupants_citizenship_id'];
                
            }

            // RELATIONSHIP TO OWNER
            $occupants_relationship_to_owner = array();
            if(isset($_POST['occupants_relationship_to_owner'])) {
                $occupants_relationship_to_owner = $_POST['occupants_relationship_to_owner'];
                
            }

            // SOCIAL STATUS
            $occupants_social_status = array();
            if(isset($_POST['occupants_social_status'])) {
                $occupants_social_status = $_POST['occupants_social_status'];
                
            }
        // 
		
		// VALIDATE FOR ERRORS
		if($err == 0) { // there are no errors

			
			$upass = encryptStr($id_suggestion);
			
			// 
			$sql = $pdo->prepare("INSERT INTO unit_owners (
                unit_owner_id,
                upass,
                firstname,
                middlename,
                lastname,
                gender,
                citizenship_id,
                birthdate,
                parking
            ) VALUES(
                :unit_owner_id,
                :upass,
                :firstname,
                :middlename,
                :lastname,
                :gender,
                :citizenship_id,
                :birthdate,
                :parking
            )");
			$sql->bindParam(":unit_owner_id",$id_suggestion);
			$sql->bindParam(":upass",$upass);
			$sql->bindParam(":firstname",$firstname);
			$sql->bindParam(":middlename",$middlename);
			$sql->bindParam(":lastname",$lastname);
			$sql->bindParam(":gender",$gender);
			$sql->bindParam(":citizenship_id",$citizenship_id);
            $sql->bindParam(":birthdate",$birthdate);
            $sql->bindParam(":parking", $unit_owner_parking);
			$sql->execute();

			$id_of_unit_owner = $pdo->lastInsertId();
			
			// 
			$sql2 = $pdo->prepare("INSERT INTO units (
                unit_name,
                sub_property_id,
                unit_owner_id,
                property_id,
                unit_capacity,
                unit_type,
                unit_area
            ) VALUES(
                :unit_name,
                :sub_property_id,
                :unit_owner_id,
                :property_id,
                :unit_capacity,
                :unit_type,
                :unit_area
            )");
			$sql2->bindParam(":unit_name",$unit_name);
			$sql2->bindParam(":sub_property_id",$sub_property_id);
			$sql2->bindParam(":unit_owner_id",$id_of_unit_owner);
			$sql2->bindParam(":property_id",$property_id);
			$sql2->bindParam(":unit_capacity",$unit_capacity);
			$sql2->bindParam(":unit_type",$unit_type);
			$sql2->bindParam(":unit_area",$unit_area);
			$sql2->execute();

			$unit_id = $pdo->lastInsertId();

			
				
			$sql3 = $pdo->prepare("INSERT INTO tenants (
                tenant_id,
                upass,
                firstname,
                middlename,
                lastname,
                gender,
                birthdate,
                citizenship_id,
                relationship_to_owner,
                social_status,
                parking
            ) VALUES(
                :tenant_id,
                :upass,
                :firstname,
                :middlename,
                :lastname,
                :gender,
                :birthdate,
                :citizenship_id,
                :relationship_to_owner,
                :social_status,
                :parking
            )");

			foreach($tenants_firstname as $key => $tenant_name) {

                    if(!empty($tenant_name) && !empty($tenants_lastname[$key])) {

                    $sql = $pdo->prepare("SELECT tenant_id FROM tenants ORDER BY id DESC LIMIT 1");
						$sql->execute();
						if($sql->rowCount()) {
							$_data = $sql->fetch(PDO::FETCH_ASSOC);
							$tenant_id = $_data['tenant_id'] + 1;
						} else {
							$tenant_id = 1001;
						}

                    //PASSWORD FOR TENANT
            		$tenant_upass = encryptStr($tenant_id);

					$sql3->bindParam(":tenant_id",$tenant_id);
					$sql3->bindParam(":upass",$tenant_upass);
					$sql3->bindParam(":firstname",$tenant_name);
					$sql3->bindParam(":middlename",$tenants_middlename[$key]);
					$sql3->bindParam(":lastname",$tenants_lastname[$key]);
					$sql3->bindParam(":gender",$tenants_gender[$key]);
					$sql3->bindParam(":birthdate",$tenants_birthdate[$key]);
					$sql3->bindParam(":citizenship_id",$tenants_citizenship_id[$key]);
					$sql3->bindParam(":relationship_to_owner",$tenants_relationship_to_owner[$key]);
                    $sql3->bindParam(":social_status",$tenants_social_status[$key]);
                    $sql3->bindParam(":parking", $tenant_parking[$key]);

					$sql3->execute();

					$inserted_tenant_id = $pdo->lastInsertId();

					$sql5 = $pdo->prepare("INSERT INTO unit_tenants (
						unit_id,
						tenant_id,
						date_from
					) VALUES(
						:unit_id,
						:tenant_id,
						:date_from
					)");

				$sql5->bindParam(":unit_id",$unit_id);
				$sql5->bindParam(":tenant_id",$inserted_tenant_id);
				$sql5->bindParam(":date_from",$date_from);
				$sql5->execute();


				}

            }
			
			$sql4 = $pdo->prepare("INSERT INTO occupants (
					unit_id,
					firstname,
					middlename,
					lastname,
					gender,
					birthdate,
					citizenship_id,
					relationship_to_tenant,
					social_status
				) VALUES(
					:unit_id,
					:firstname,
					:middlename,
					:lastname,
					:gender,
					:birthdate,
					:citizenship_id,
					:relationship_to_tenant,
					:social_status
				)");

				$sql4->bindParam(":unit_id",$unit_id);

				foreach($occupants_firstname as $key => $occupant_name) {

                    if(!empty($occupant_name) && !empty($occupants_lastname[$key])) {

					$sql4->bindParam(":firstname",$occupant_name);
					$sql4->bindParam(":middlename",$occupants_middlename[$key]);
					$sql4->bindParam(":lastname",$occupants_lastname[$key]);
					$sql4->bindParam(":gender",$occupants_gender[$key]);
					$sql4->bindParam(":birthdate",$occupants_birthdate[$key]);
					$sql4->bindParam(":citizenship_id",$occupants_citizenship_id[$key]);
					$sql4->bindParam(":relationship_to_tenant",$occupants_relationship_to_owner[$key]);
					$sql4->bindParam(":social_status",$occupants_social_status[$key]);

					$sql4->execute();
					}

            	}
			
			// record to system log
			systemLog('unit',$unit_id,'add','');

			$_SESSION['sys_units_add_suc'] = renderLang($units_unit_added);
			header('location: /add-unit-eu');
			
		} else { // error found
			
			$_SESSION['sys_units_add_err'] = renderLang($form_error);
			header('location: /add-unit-eu');
			
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