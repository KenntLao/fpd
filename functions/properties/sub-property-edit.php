<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('sub-property-edit')) {
	
		$err = 0;
		$id = $_POST['id'];
		
		// check if ID exists
		$sql = $pdo->prepare("SELECT * FROM sub_properties WHERE id = :id LIMIT 1");
		$sql->bindParam(":id",$id);
		$sql->execute();
		$data = $sql->fetch(PDO::FETCH_ASSOC);
		
		$pid = $data['property_id'];
		
		if($sql->rowCount()) {

			// PROCESS FORM

			// SUB PROPERTY NAME
			$sub_property_name = '';
			if(isset($_POST['sub_property_name'])) {
				$sub_property_name = trim($_POST['sub_property_name']);
				if(strlen($sub_property_name) == 0) {
					$err++;
					$_SESSION['sys_sub_properties_edit_user_sub_property_name_err'] = renderLang($properties_sub_property_name_required);
				} else {
                    $_SESSION['sys_sub_properties_edit_sub_property_name_val'] = $sub_property_name;
				}
			}

				// association dues
			$association_dues = '';
			if(isset($_POST['sub_association_dues'])) {
				$association_dues = $_POST['sub_association_dues'];
				$_SESSION['sys_sub_properties_edit_association_dues_val'] = $association_dues;
				if(empty($association_dues)) {
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
				$_SESSION['sys_sub_properties_edit_joining_fee_val'] = $joining_fee;
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

            // equipment key
            $e_key_id = array();
            if(isset($_POST['e_key_id'])) {
                $e_key_id = $_POST['e_key_id'];
            }

			// SUB PROPERTY AMENITIES

				// aminity name
				$amenity_name = array();
				if(isset($_POST['amenity_name'])) {
					$amenity_name = $_POST['amenity_name'];
				}

				// amenity description
				$amenity_description = array();
				if(isset($_POST['amenity_description'])) {
					$amenity_description = $_POST['amenity_description'];
				}
				// amenity id
				$amenities_id = array();
				if(isset($_POST['amenities_id'])) {
					$amenities_id = $_POST['amenities_id'];
				}

			// VALIDATE FOR ERRORS
			if($err == 0) { // there are no errors

				// check for changes
				$change_logs = array();
				if($sub_property_name != $data['sub_property_name']) {
					$tmp = 'properties_sub_property_name::'.$data['sub_property_name'].'=='.$sub_property_name;
					array_push($change_logs,$tmp);
				}

				if($association_dues != $data['sub_property_association_dues']) {
					$tmp = 'properties_association_dues::'.$data['sub_property_association_dues'].'=='.$association_dues;
					array_push($change_logs,$tmp);
				}

				if($joining_fee != $data['sub_property_joining_fee']) {
					$tmp = 'properties_sub_property_building_data_Joining_Fee::'.$data['sub_property_joining_fee'].'=='.$joining_fee;
					array_push($change_logs,$tmp);
				}

				if($inclusive_of != $data['sub_property_inclusive_of']) {
					$tmp = 'properties_sub_property_building_data_inclusive_of::'.$data['sub_property_inclusive_of'].'=='.$inclusive_of;
					array_push($change_logs,$tmp);
				}

                // update account language table
                $sql = $pdo->prepare("UPDATE sub_properties SET
                    sub_property_name = :sub_property_name,
                    sub_property_association_dues = :sub_property_association_dues,
                    sub_property_joining_fee = :sub_property_joining_fee,
                    sub_property_inclusive_of = :sub_property_inclusive_of
                WHERE id = :id");
                $sql->bindParam(":id",$id);
                $sql->bindParam(":sub_property_name",$sub_property_name);
                $sql->bindParam(":sub_property_association_dues",$association_dues);
                $sql->bindParam(":sub_property_joining_fee",$joining_fee);
                $sql->bindParam(":sub_property_inclusive_of",$inclusive_of);
                $sql->execute();

                foreach($e_key_id as $key => $key_id) {
                        
                    $sql1 = $pdo->prepare("SELECT * FROM equipments WHERE id = :id  LIMIT 1");
                    $sql1->bindParam(":id", $key_id);
                    $sql1->execute();
                    if($sql1->rowCount()) { // update

                        $_data1 = $sql1->fetch(PDO::FETCH_ASSOC);

                        $sql2 = $pdo->prepare("UPDATE equipments SET
                            serial_number = :equipment_make_model, 
                            equipment_name = :equipment_name,
                            equipment_type = :equipment_type,
                            equipment_capacity = :equipment_capacity,
                            equipment_description = :equipment_remarks,
                            date_acquired = :equipment_date_acquired,
                            amount = :equipment_quantity,
                            supplier = :equipment_supplier
                        WHERE id = :id");

                        $sql2->bindParam(":equipment_make_model", $equipment_make_model[$key]);
                        $sql2->bindParam(":equipment_name", $equipment_name[$key]);
                        $sql2->bindParam(":equipment_type", $equipment_type[$key]);
                        $sql2->bindParam(":equipment_capacity", $equipment_capacity[$key]);
                        $sql2->bindParam(":equipment_remarks", $equipment_remarks[$key]);
                        $sql2->bindParam(":equipment_date_acquired", $equipment_date_acquired[$key]);
                        $sql2->bindParam(":equipment_quantity", $equipment_quantity[$key]);
                        $sql2->bindParam(":equipment_supplier", $equipment_supplier[$key]);
                        $sql2->bindParam(":id", $key_id);
                        $sql2->execute();

                    } else { // insert

                            
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

                            if (!empty($equipment_quantity[$key]) && !empty($equipment_name[$key]) ) {

                                $sql2->bindParam(":sub_property_id", $id);
                                $sql2->bindParam(":equipment_make_model", $equipment_make_model[$key]);
                                $sql2->bindParam(":equipment_name", $equipment_name[$key]);
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

                foreach($amenities_id as $key => $amenity_id) {
                        
                    $sql3 = $pdo->prepare("SELECT * FROM sub_properties_amenities WHERE id = :id  LIMIT 1");
                    $sql3->bindParam(":id", $amenity_id);
                    $sql3->execute();
                    if($sql3->rowCount()) { // update

                        $_data3 = $sql3->fetch(PDO::FETCH_ASSOC);

                        $sql4 = $pdo->prepare("UPDATE sub_properties_amenities SET
                            amenity_name = :amenity_name, 
                            amenity_description = :amenity_description
                        WHERE id = :id");

                        $sql4->bindParam(":amenity_name", $amenity_name[$key]);
                        $sql4->bindParam(":amenity_description", $amenity_description[$key]);
                        $sql4->bindParam(":id", $amenity_id);
                        $sql4->execute();

                    } else { // insert

                        $sql4 = $pdo->prepare("INSERT INTO sub_properties_amenities (
                            sub_property_id, 
                            amenity_name, 
                            amenity_description
                        ) VALUES (
                            :sub_property_id, 
                            :amenity_name, 
                            :amenity_description
                        )");

                        if (!empty($amenity_name[$key])) {

                            $sql4->bindParam(":sub_property_id", $id);
                            $sql4->bindParam(":amenity_name", $amenity_name[$key]);
                            $sql4->bindParam(":amenity_description", $amenity_description[$key]);
                            $sql4->execute();
                        } 
                    }              	
                }

                // record to system log
                $change_log = implode(';;',$change_logs);
                systemLog('sub_property',$id,'update',$change_log);

                $_SESSION['sys_sub_properties_edit_suc'] = renderLang($properties_sub_property_updated);
                header('location: /edit-sub-property/'.$pid);

			} else { // error found

                $_SESSION['sys_sub_properties_edit_err'] = renderLang($form_error);
                header('location: /edit-sub-property/'.$pid);

			}

		} else {

			$_SESSION['sys_sub_properties_edit_err'] = renderLang($form_id_not_found);
            header('location: /edit-sub-property/'.$pid);
		}

		//header('location: /edit-sub-property/'.$pid.'/'.$id);
		
	} else { // permission not found

		$_SESSION['sys_permission_err'] = renderLang($permission_message_1);
		header('location: /dashboard');

	}
} else { // no session found, redirect to login page

	$_SESSION['sys_login_err'] = renderLang($login_msg_err_4);
	header('location: /');

}
?>