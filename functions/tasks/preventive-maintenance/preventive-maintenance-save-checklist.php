<?php 
require($_SERVER['DOCUMENT_ROOT']."/includes/config.php");

if(checkSession()) {

    if(checkPermission('preventive-maintenance-checklist')) {

		$err = 0;
		
		$pm_id = $_POST['pm_id'];
		$sql = $pdo->prepare("SELECT * FROM preventive_maintenance WHERE id = :id LIMIT 1");
		$sql->bindParam(":id", $pm_id);
		$sql->execute();
		$_data = $sql->fetch(PDO::FETCH_ASSOC);

		$equipment_id = $_data['equipment_id'];

        $month = NULL;
        if(isset($_POST['month'])) {
            $month = trim($_POST['month']);
		}

		$date = '';
		if(isset($_POST['date'])) {
			$date = trim($_POST['date']);
		}

        $equipment_name = '';
        if(isset($_POST['equipment_name'])) {
            $equipment_name = trim($_POST['equipment_name']);
        }

        $serial_number = '';
        if(isset($_POST['serial_number'])) {
            $serial_number = trim($_POST['serial_number']);
        }

        $equipment_code = '';
        if(isset($_POST['equipment_code'])) {
			$equipment_code = trim($_POST['equipment_code']);
		}

		$equipment_location = '';
		if(isset($_POST['equipment_location'])) {
			$equipment_location = trim($_POST['equipment_location']);
		}
		
		if($err == 0) {

			// update equipment
			$sql = $pdo->prepare("UPDATE equipments SET 
				serial_number = :serial_number, 
				equipment_name = :equipment_name, 
				equipment_description = :equipment_description, 
				equipment_location = :equipment_location 
			WHERE id = :equipment_id");
			$sql->bindParam(":serial_number", $serial_number);
			$sql->bindParam(":equipment_name", $equipment_name);
			$sql->bindParam(":equipment_description", $equipment_code);
			$sql->bindParam(":equipment_location", $equipment_location);
			$sql->bindParam(":equipment_id", $equipment_id);
			$sql->execute();

			// update pm
			$sql = $pdo->prepare("UPDATE preventive_maintenance SET 
				month_of = :month, 
				before_picture = :before_pictures, 
				after_picture = :after_pictures,
				date = :date
			WHERE id = :pm_id");
			$sql->bindParam(":month", $month);
			$sql->bindParam(":pm_id", $pm_id);
			$sql->bindParam(":date", $date);

			// before pictures
				$before_attachments_arr = array();
				$before_attachment_count = count($_FILES['before_pictures']);

				if(!is_dir($sys_upload_dir.'preventive-maintenance')) {
					mkdir($sys_upload_dir.'preventive-maintenance', 0755, true);
				}

				for($i = 0; $i < $before_attachment_count; $i++) {

					if(!empty($_FILES['before_pictures']['name'][$i])) {
		
						$file = explode('.', $_FILES['before_pictures']['name'][$i]);
						$file_name = $file[0];
						$file_ext = $file[1];
		
						$time = time();
		
						$attachment_name = $file_name.'-'.$time.'.'.$file_ext;
		
						$file_tmp = $_FILES['before_pictures']['tmp_name'][$i];
						$file_size = $_FILES['before_pictures']['size'][$i];
						
						// save file
						move_uploaded_file($file_tmp, $sys_upload_dir.'preventive-maintenance/'.$attachment_name);

						$before_attachments_arr[] = $attachment_name;
						
					}

				}

				if(!empty($before_attachments_arr)) {
					$before_attachment_name = implode(',', $before_attachments_arr);
				} else {
					$before_attachment_name = $_data['before_picture'];
				}
				$sql->bindParam(":before_pictures", $before_attachment_name);
			// 

			// after pictures
				$after_attachments_arr = array();
				$after_attachment_count = count($_FILES['after_pictures']);

				if(!is_dir($sys_upload_dir.'preventive-maintenance')) {
					mkdir($sys_upload_dir.'preventive-maintenance', 0755, true);
				}

				for($i = 0; $i < $after_attachment_count; $i++) {

					if(!empty($_FILES['after_pictures']['name'][$i])) {
		
						$file = explode('.', $_FILES['after_pictures']['name'][$i]);
						$file_name = $file[0];
						$file_ext = $file[1];
		
						$time = time();
		
						$attachment_name = $file_name.'-'.$time.'.'.$file_ext;
		
						$file_tmp = $_FILES['after_pictures']['tmp_name'][$i];
						$file_size = $_FILES['after_pictures']['size'][$i];
						
						// save file
						move_uploaded_file($file_tmp, $sys_upload_dir.'preventive-maintenance/'.$attachment_name);

						$after_attachments_arr[] = $attachment_name;
						
					}

				}

				if(!empty($after_attachments_arr)) {
					$after_attachment_name = implode(',', $after_attachments_arr);
				} else {
					$after_attachment_name = $_data['after_picture'];
				}
				$sql->bindParam(":after_pictures", $after_attachment_name);
			// 

			$sql->execute();

			$_SESSION['sys-preventive-maintenance-add-suc'] = renderLang($preventive_maintenance_updated);
			header('location: /preventive-maintenance-form/'.$pm_id);

		} else {

			$_SESSION['sys-preventive-maintenance-add-err'] = renderLang($form_error);
			header('location: /preventive-maintenance-form/'.$pm_id);

		}

    } else {// permission not found

        $_SESSION['sys_permission_err'] = renderLang($permission_message_1);
        header('location: /dashboard');

}

} else {// no session found, redirect to login page

    $_SESSION['sys_login_err'] = renderLang($login_msg_err_4);
    header('location: /');

}
?>