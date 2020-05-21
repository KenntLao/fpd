<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('unit-add')) {
	
		$err = 0;
		
		$property_id = $_POST['property_id'];
		$sub_property_id = $_POST['sub_property_id'];
		
		// PROCESS FORM
		
		// UNIT NAME
		$unit_name = '';
		if(isset($_POST['unit_name'])) {
			$unit_name = trim($_POST['unit_name']);
			if(strlen($unit_name) == 0) {
				$err++;
				$_SESSION['sys_units_add_unit_name_err'] = renderLang($units_unit_name_required);
			} else {
				
				$_SESSION['sys_units_add_unit_name_val'] = $unit_name;
				
				// check if user name already exists
				$sql = $pdo->prepare("SELECT unit_name, temp_del FROM units WHERE unit_name = :unit_name AND sub_property_id = :sub_property_id AND temp_del = 0 LIMIT 1");
				$sql->bindParam(":sub_property_id",$sub_property_id);
				$sql->bindParam(":unit_name",$unit_name);
				$sql->execute();
				if($sql->rowCount()) {
					$err++;
					$_SESSION['sys_units_add_unit_name_err'] = renderLang($units_unit_name_exists);
				}
			}
		}

		// UNIT TYPE
		$unit_type = 0;
		if(isset($_POST['unit_type'])) {
			$unit_type = trim($_POST['unit_type']);
			$_SESSION['sys_units_add_unit_type_val'] = $unit_type;
			$unit_type_exists = 0;
			foreach($unit_type_arr as $unit_type_data) {
				if($unit_type_data[0] == $unit_type_exists) {
					$unit_type_exists = 1;
				}
			}
			if(!$unit_type_exists) {
				$err++;
				$_SESSION['sys_units_add_unit_type_err'] = renderLang($units_select_valid_unit_type);
			}
		}
		
		// UNIT AREA
		$unit_area = 0;
		if(isset($_POST['unit_area'])) {
			$unit_area = trim($_POST['unit_area']);
			if(strlen($unit_area) == 0) {
				$err++;
				$_SESSION['sys_units_add_unit_area_err'] = renderLang($units_unit_area_required);
			} else {
				$unit_area = str_replace(',','',$unit_area);
				if(!is_numeric($unit_area)) {
					$err++;
					$_SESSION['sys_units_add_unit_area_err'] = renderLang($units_unit_area_must_be_a_number);
				} else {
					if($unit_area == 0) {
						$err++;
						$_SESSION['sys_units_add_unit_area_err'] = renderLang($units_unit_area_cannot_be_zero);
					}
				}
				$_SESSION['sys_units_add_unit_area_val'] = $unit_area;
			}
		}
		
		// VACANCY STATUS
		$vacancy_status = 0;
		if(isset($_POST['vacancy_status'])) {
			$vacancy_status = trim($_POST['vacancy_status']);
			if(strlen($vacancy_status) == 0) {
				$err++;
				$_SESSION['sys_units_add_vacancy_status_err'] = renderLang($units_vacancy_status_required);
			} else {
				$_SESSION['sys_units_add_vacancy_status_val'] = $vacancy_status;
			}
		}
		
		// UNIT OWNER
		$unit_owner_id = 0;
		if(!$vacancy_status) { // check if vacant status is VACANT OR NOT
			if(isset($_POST['unit_owner_id'])) {
				$unit_owner_id = trim($_POST['unit_owner_id']);
				if(strlen($unit_owner_id) == 0) {
					$err++;
					$_SESSION['sys_units_add_unit_owner_id_err'] = renderLang($units_unit_owner_id_required);
				} else {
					$_SESSION['sys_units_add_unit_owner_id_val'] = $unit_owner_id;
				}
			}
		}

		// VACANCY TYPE
		$vacancy_type = 0;
		if(isset($_POST['vacancy_type'])) {
			$vacancy_type = trim($_POST['vacancy_type']);
			if(strlen($vacancy_type) == 0) {
				$err++;
				$_SESSION['sys_units_add_vacancy_type_err'] = renderLang($units_vacancy_type_required);
			} else {
				$_SESSION['sys_units_add_vacancy_type_val'] = $vacancy_type;
			}
		}
		
		// UNIT CAPACITY
		$unit_capacity = 0;
		if(isset($_POST['unit_capacity'])) { 
			$unit_capacity = trim($_POST['unit_capacity']);
			if(strlen($unit_capacity) == 0) {
				$err++;
				$_SESSION['sys_units_add_unit_capacity_err'] = renderLang($units_unit_capacity_required);
			} else {
				if($unit_capacity > 0) {
					$_SESSION['sys_units_add_unit_capacity_val'] = $unit_capacity;
				} else {
					if($unit_type == 0) {
						$err++;
						$_SESSION['sys_units_add_unit_capacity_err'] = renderLang($units_unit_capacity_must_be_at_least_one);
					}
				}

			}
		}
		
		// COMMERCIAL TYPE
		$commercial_unit_type_id = 0;
		if(isset($_POST['commercial_unit_type_id'])) { 
			$commercial_unit_type_id = trim($_POST['commercial_unit_type_id']);
			if(strlen($commercial_unit_type_id) == 0) {
				$err++;
				$_SESSION['sys_units_add_commercial_unit_type_id_err'] = renderLang($units_commercial_unit_type_id_required);
			} else {
				if($commercial_unit_type_id > 0) {
					$_SESSION['sys_units_add_commercial_unit_type_id_val'] = $commercial_unit_type_id;
				} else {
					if($unit_type == 1) {
						$err++;
						$_SESSION['sys_units_add_commercial_unit_type_id_err'] = renderLang($units_commercial_unit_type_id_must_be_at_least_one);
					}
				}

			}
		}
		
		// VALIDATE FOR ERRORS
		if($err == 0) { // there are no errors
			
			// insert into units table
			$sql = $pdo->prepare("INSERT INTO units(
					id,
					unit_name,
					unit_owner_id,
					property_id,
					sub_property_id,
					unit_type,
					unit_capacity,
					unit_area,
					commercial_unit_type_id,
					vacancy_status,
					vacancy_type
				) VALUES(
					NULL,
					:unit_name,
					:unit_owner_id,
					:property_id,
					:sub_property_id,
					:unit_type,
					:unit_capacity,
					:unit_area,
					:commercial_unit_type_id,
					:vacancy_status,
					:vacancy_type
				)");
			$sql->bindParam(":unit_name",$unit_name);
			$sql->bindParam(":unit_owner_id",$unit_owner_id);
			$sql->bindParam(":property_id",$property_id);
			$sql->bindParam(":sub_property_id",$sub_property_id);
			$sql->bindParam(":unit_type",$unit_type);
			$sql->bindParam(":unit_capacity",$unit_capacity);
			$sql->bindParam(":unit_area",$unit_area);
			$sql->bindParam(":commercial_unit_type_id",$commercial_unit_type_id);
			$sql->bindParam(":vacancy_status",$vacancy_status);
			$sql->bindParam(":vacancy_type",$vacancy_type);
			$sql->execute();
			
			// get ID of new unit
			$sql = $pdo->prepare("SELECT id, unit_name FROM units WHERE unit_name = :unit_name LIMIT 1");
			$sql->bindParam(":unit_name",$unit_name);
			$sql->execute();
			$data = $sql->fetch(PDO::FETCH_ASSOC);
			
			// record to system log
			systemLog('unit',$data['id'],'add','');

			$_SESSION['sys_units_add_suc'] = renderLang($units_unit_added);
			header('location: /sub-property-units/'.$sub_property_id);
			
		} else { // error found
			
			$_SESSION['sys_units_add_err'] = renderLang($form_error);
			header('location: /add-unit/'.$property_id.'/'.$sub_property_id);
			
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