<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('property-edit')) {
	
		$err = 0;
		$id = $_POST['id'];
		
		// check if ID exists
		$sql = $pdo->prepare("SELECT * FROM properties WHERE id = ".$id." LIMIT 1");
		$sql->bindParam(":id",$id);
		$sql->execute();
		$data = $sql->fetch(PDO::FETCH_ASSOC);
		if($sql->rowCount()) {

			// PROCESS FORM

			// PROPERTY ID
			$property_id = '';
			if(isset($_POST['property_id'])) {
				$property_id = strtoupper(trim($_POST['property_id']));
				if(strlen($property_id) == 0) {
					$err++;
					$_SESSION['sys_properties_edit_user_property_id_err'] = renderLang($properties_property_id_required);
				} else {
					// check if property code already exists
					$sql = $pdo->prepare("SELECT property_id FROM properties WHERE property_id = :property_id AND id <> ".$id." AND temp_del = 0 LIMIT 1");
					$sql->bindParam(":property_id",$property_id);
					$sql->execute();
					if($sql->rowCount()) {
						$err++;
						$_SESSION['sys_properties_edit_property_id_err'] = renderLang($properties_property_id_exists);
					}
				}
			}

			// PROPERTY CODE
			$property_code = '';
			if(isset($_POST['property_code'])) {
				$property_code = strtoupper(trim($_POST['property_code']));
				if(strlen($property_code) == 0) {
					$err++;
					$_SESSION['sys_properties_edit_user_property_code_err'] = renderLang($properties_property_code_required);
				} else {
					// check if property code already exists
					$sql = $pdo->prepare("SELECT property_code FROM properties WHERE property_code = :property_code AND id <> ".$id." AND temp_del = 0 LIMIT 1");
					$sql->bindParam(":property_code",$property_code);
					$sql->execute();
					if($sql->rowCount()) {
						$err++;
						$_SESSION['sys_properties_edit_property_code_err'] = renderLang($properties_property_code_exists);
					} else {
                        if(strpos($property_id, '-')) {
                            $code = explode('-', $property_id);
                            $property_id = $code[0].'-'.$property_code;
                        } else {
                            $property_id = $property_id.'-'.$property_code;
                        }
                        $_SESSION['sys_properties_edit_property_code_val'] = $property_code;
					}
				}
			}

			// PROPERTY NAME
			$property_name = '';
			if(isset($_POST['property_name'])) {
				$property_name = trim($_POST['property_name']);
				if(strlen($property_name) == 0) {
					$err++;
					$_SESSION['sys_properties_edit_user_property_name_err'] = renderLang($properties_property_name_required);
				} else {
					// check if property code already exists
					$sql = $pdo->prepare("SELECT property_name FROM properties WHERE property_name = :property_name AND id <> ".$id." AND temp_del = 0 LIMIT 1");
					$sql->bindParam(":property_name",$property_name);
					$sql->execute();
					if($sql->rowCount()) {
						$err++;
						$_SESSION['sys_properties_edit_property_name_err'] = renderLang($properties_property_name_exists);
					} else {
						$_SESSION['sys_properties_edit_property_name_val'] = $property_name;
					}
				}
			}

			// STATUS
			$status = 0;
			if(isset($_POST['status'])) {
				$status = trim($_POST['status']);
				$_SESSION['sys_properties_edit_status_val'] = $status;
				$status_exists = 0;
				foreach($status_arr as $status_data) {
					if($status_data[0] == $status_exists) {
						$status_exists = 1;
					}
				}
				if(!$status_exists) {
					$err++;
					$_SESSION['sys_properties_edit_status_err'] = 'Please select a valid status.';
				}
			}

			// CLIENT ID
			$client_id = 0;
			if(isset($_POST['client_id'])) {
				$client_id = trim($_POST['client_id']);
				$_SESSION['sys_properties_edit_client_id_val'] = $client_id;
            }
            
            // CLUSTER ID
            $cluster_id = 0;
            if(isset($_POST['cluster'])) {
                $cluster_id = trim($_POST['cluster']);
            }

			// VALIDATE FOR ERRORS
			if($err == 0) { // there are no errors

				// check for changes
				$change_logs = array();
				if($property_id != $data['property_id']) {
					$tmp = 'properties_property_id::'.$data['property_id'].'=='.$property_id;
					array_push($change_logs,$tmp);
				}
				if($property_code != $data['property_code']) {
					$tmp = 'properties_property_code::'.$data['property_code'].'=='.$property_code;
					array_push($change_logs,$tmp);
				}
				if($property_name != $data['property_name']) {
					$tmp = 'properties_property_name::'.$data['property_name'].'=='.$property_name;
					array_push($change_logs,$tmp);
				}
				if($property_name != $data['client_id']) {
					$tmp = 'clients_client::'.$data['client_id'].'=='.$property_name;
					array_push($change_logs,$tmp);
				}
				if($status != $data['status']) {
					$tmp = 'lang_status::'.$data['status'].'=='.$status;
					array_push($change_logs,$tmp);
                }
                if($cluster_id != $data['cluster_id']) {
                    $tmp = 'cluster::'.$data['cluster_id'].'=='.$cluster_id;
                    array_push($change_logs, $tmp);
                }

				// check if there is are changes made
				if(count($change_logs) > 0) {

					// update account language table
					$sql = $pdo->prepare("UPDATE properties SET
						property_id = :property_id,
						property_code = :property_code,
						property_name = :property_name,
						client_id = :client_id,
                        cluster_id = :cluster_id,
						status = :status
					WHERE id = ".$id);
					$sql->bindParam(":property_id",$property_id);
					$sql->bindParam(":property_code",$property_code);
					$sql->bindParam(":property_name",$property_name);
                    $sql->bindParam(":client_id",$client_id);
                    $sql->bindParam(":cluster_id",$cluster_id);
					$sql->bindParam(":status",$status);
					$sql->execute();

					// record to system log
					$change_log = implode(';;',$change_logs);
					systemLog('property',$id,'update',$change_log);

					// if cluster is not empty
					if (!empty($cluster_id)) {

						// get field table clusters 
						$assigned = getField('assigned', 'clusters', 'id ='.$cluster_id);

						// notification cluster assigned
						$users = getTable('users');
						push_notification('property', $id, $assigned, 'employee', 'cluster_assigned');
						foreach ($users as $user) {
							push_notification('property', $id, $assigned, 'user', 'cluster_assigned');
						}

					}

					$_SESSION['sys_properties_edit_suc'] = renderLang($properties_property_updated);

				} else { // no changes made

					$_SESSION['sys_properties_edit_err'] = renderLang($form_no_changes);

				}

			} else { // error found

				$_SESSION['sys_properties_edit_err'] = renderLang($form_error);

			}

		} else {

			$_SESSION['sys_properties_edit_err'] = renderLang($form_id_not_found);

		}

		header('location: /edit-property/'.$id);
		
	} else { // permission not found

		$_SESSION['sys_permission_err'] = renderLang($permission_message_1);
		header('location: /dashboard');

	}
} else { // no session found, redirect to login page

	$_SESSION['sys_login_err'] = renderLang($login_msg_err_4);
	header('location: /');

}
?>