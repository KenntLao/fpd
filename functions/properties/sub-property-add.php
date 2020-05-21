<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('sub-property-add')) {
	
		$err = 0;
		
		// PROCESS FORM
		
		// PROPERTY ID
		$property_id = 0;
		if(isset($_POST['property_id'])) {
			$property_id = strtolower(trim($_POST['property_id']));
			if(strlen($property_id) == 0) {
				$err++;
				$_SESSION['sys_sub_properties_add_property_id_err'] = renderLang($employees_property_id_required);
			} else {

				$_SESSION['sys_sub_properties_add_property_id_val'] = $property_id;

				// check if property ID is valid (existing or not deleted)
				$sql = $pdo->prepare("SELECT id, temp_del FROM properties WHERE id = :property_id AND temp_del = 0 LIMIT 1");
				$sql->bindParam(":property_id",$property_id);
				$sql->execute();
				if($sql->rowCount()) {} else {
					$err++;
					$_SESSION['sys_sub_properties_add_property_id_err'] = renderLang($employees_property_id_invalid);
				}
			}
		}
		
		// SUB PROPERTY NAME
		$sub_property_name = '';
		if(isset($_POST['sub_property_name'])) {
			$sub_property_name = trim($_POST['sub_property_name']);
			if(strlen($sub_property_name) == 0) {
				$err++;
				$_SESSION['sys_sub_properties_add_sub_property_name_err'] = renderLang($properties_sub_property_name_required);
			} else {
				
				$_SESSION['sys_sub_properties_add_sub_property_name_val'] = $sub_property_name;
				
				// check if property name already exists
				$sql = $pdo->prepare("SELECT sub_property_name, temp_del FROM sub_properties WHERE sub_property_name = :sub_property_name AND property_id = ".$property_id." AND temp_del=0 LIMIT 1");
				$sql->bindParam(":sub_property_name",$sub_property_name);
				$sql->execute();
				if($sql->rowCount()) {
					$err++;
					$_SESSION['sys_sub_properties_add_sub_property_name_err'] = renderLang($properties_sub_property_name_exists);
				}
			}
		}

		// association dues
		$association_dues = '';
		if(isset($_POST['sub_association_dues'])) {
			$association_dues = $_POST['sub_association_dues'];
			if(strlen($association_dues) == 0) {
				$association_dues = 0;
			}
		} else {

		}

		// inclusive of
		$inclusive_of = '';
		if(isset($_POST['inclusive'])) {
			$inclusive = $_POST['inclusive'];
			if(!empty($inclusive)) {
				foreach($inclusive as $value) {
					$inclusive_of .= ','.$value;
				}
			}
		}

		// joining fee
		$joining_fee = '';
		if(isset($_POST['join_fee'])) {
			$joining_fee = $_POST['join_fee'];
			if(empty($joining_fee)) {
				$joining_fee = 0;
			}
		}

		// SUB PROPERTY EQUIPMENTS
        
            // equipment name
			$equipment_name = array();
            if(isset($_POST['equipment'])) {
                $equipment_name = $_POST['equipment'];
            }

            // equipment quantity
            $equipment_quantity = array();
            if(isset($_POST['quantity'])) {
                $equipment_quantity = $_POST['quantity'];
            }

            // equipment type
            $equipment_type = array();
            if(isset($_POST['type'])) {
                $equipment_type = $_POST['type'];
            }

            // equipment make / model
            $equipment_make_model = array();
            if(isset($_POST['make_model'])) {
                $equipment_make_model = $_POST['make_model'];
            }

            // equipment capacity
            $equipment_capacity = array();
            if(isset($_POST['capacity'])) {
                $equipment_capacity = $_POST['capacity'];
            }

            // equipment date acquired
            $equipment_date_acquired = array();
            if(isset($_POST['date'])) {
                $equipment_date_acquired = $_POST['date'];
            }

            // equipment supplier
            $equipment_supplier = array();
            if(isset($_POST['supplier'])) {
                $equipment_supplier = $_POST['supplier'];
            }

            // equipment remarks
            $equipment_remarks = array();
            if(isset($_POST['remarks'])) {
                $equipment_remarks = $_POST['remarks'];
            }

            // equipment key
            $equipment_key = array();
            if(isset($_POST['equipment_key'])) {
                $equipment_key = $_POST['equipment_key'];
            }

		// SUB PROPERTY AMENITIES
			$amenity_name = array();
			$amenity_description = array();

			// aminity name
			if(isset($_POST['amenity_name'])) {
				$amenity_name = $_POST['amenity_name'];
			}

			// amenity description
			if(isset($_POST['amenity_description'])) {
				$amenity_description = $_POST['amenity_description'];
			}
		
		// VALIDATE FOR ERRORS
		if($err == 0) { // there are no errors
			
			// insert into sub properties table
			$sql = $pdo->prepare("INSERT INTO sub_properties(
					id,
					property_id,
					sub_property_name,
					sub_property_association_dues,
					sub_property_inclusive_of,
					sub_property_joining_fee
				) VALUES(
					NULL,
					:property_id,
					:sub_property_name,
					:sub_property_dues,
					:sub_property_inclusive,
					:sub_property_joining_fee
				)");
			$sql->bindParam(":property_id",$property_id);
			$sql->bindParam(":sub_property_name",$sub_property_name);
			$sql->bindParam(":sub_property_dues",$association_dues);
			$sql->bindParam(":sub_property_inclusive",$inclusive_of);
			$sql->bindParam(":sub_property_joining_fee",$joining_fee);
			$sql->execute();
			
            // get ID of new sub property
            
            $sub_property_id = $pdo->lastInsertId();

			// insert into sub_properties_amenities table
			if(!empty($amenity_name)){

				$sql1 = $pdo->prepare("INSERT INTO `sub_properties_amenities` (`id`, `sub_property_id`, `amenity_name`, `amenity_description`, `temp_del`) VALUES (NULL, :sub_property_id, :amenity_name, :description, '0')");
				$sql1->bindParam(":sub_property_id", $sub_property_id);
				foreach($amenity_name as $key => $value) {

					if(!empty($value)) {
						$sql1->bindParam(":amenity_name", $value);
						$sql1->bindParam(":description", $amenity_description[$key]);
						$sql1->execute();
					}

				}

            }
            
            // insert into equipments
            if(!empty($equipment_name)) {

                $sql2 = $pdo->prepare("INSERT INTO equipments (
                    sub_property_id, 
                    serial_number, 
                    equipment_name, 
                    equipment_type, 
                    equipment_capacity, 
                    equipment_description, 
                    date_acquired, 
                    amount, 
                    supplier,
                    equipment_key
                ) VALUES (
                    :sub_property_id, 
                    :equipment_make_model, 
                    :equipment_name, 
                    :equipment_type, 
                    :equipment_capacity, 
                    :equipment_remarks, 
                    :equipment_date_acquired, 
                    :equipment_quantity, 
                    :equipment_supplier,
                    :equipment_key
                )");
                
                $sql2->bindParam(":sub_property_id", $sub_property_id);
                
                foreach($equipment_name as $key => $equipment) {

                    if(!empty($equipment_quantity[$key]) && !empty($equipment)) {

                        $sql2->bindParam(":equipment_make_model", $equipment_make_model[$key]);
                        $sql2->bindParam(":equipment_name", $equipment);
                        $sql2->bindParam(":equipment_type", $equipment_type[$key]);
                        $sql2->bindParam(":equipment_capacity", $equipment_capacity[$key]);
                        $sql2->bindParam(":equipment_remarks", $equipment_remarks[$key]);
                        $sql2->bindParam(":equipment_date_acquired", $equipment_date_acquired[$key]);
                        $sql2->bindParam(":equipment_quantity", $equipment_quantity[$key]);
                        $sql2->bindParam(":equipment_supplier", $equipment_supplier[$key]);
                        $sql2->bindParam(":equipment_key", $equipment_key[$key]);

                        $sql2->execute();

                    }

                }

            }

			// record to system log
			systemLog('sub_property',$sub_property_id,'add','');

			$_SESSION['sys_sub_properties_add_suc'] = renderLang($properties_sub_property_added);
			header('location: /property-sub-properties/'.$property_id);
			
		} else { // error found
			
			$_SESSION['sys_sub_properties_add_err'] = renderLang($form_error);
			header('location: /add-sub-property/'.$property_id);
			
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