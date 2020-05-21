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

        $file_name = '';
        $file_ext = '';

        $file = '';
        if(isset($_FILES['units_file']['name'])) {

            $file = $_FILES['units_file']['name'];

            $tmp = explode('.', $file);
            $file_ext = $tmp[1];
            $file_name = $tmp[0];

            if($file_ext != 'csv') {
                $err++;
                echo 'Ivalid file type.';
            }

        } else {
            $err++;
            $file = '';
        }

        if($err == 0) {

            $handle = fopen($_FILES['units_file']['tmp_name'], "r");

            $start = 2;
            $end = 2000;
            $i = 1;

            while(($row = fgetcsv($handle)) !== false) {

                // unit name - unit type - unit area - status - unit capacity - firstname - middlename - lastname - gender - civil status - birthdate - citizenship

                $unit_name = trim($row[0]);
                $unit_type = trim($row[1]);
                foreach($unit_type_arr as $key => $type) {
                    if(strtolower($unit_type) == strtolower($type[1][0])) {
                        $unit_type = $key;
                    }
                }
                $unit_area = trim($row[2]);
                $vacant = trim($row[3]);
                if(strtolower($vacant) == 'yes') {
                    $vacant = 1;
                } else {
                    $vacant = 0;
                }
                $unit_capacity = trim($row[4]);

                // unit owner
                $firstname = trim($row[5]);
                $middlename = trim($row[6]);
                $lastname = trim($row[7]);
                $gender = trim($row[8]);
                switch(strtolower($gender)) {
                    case 'female':
                        $gender = 0;
                        break;
                    case 'male':
                        $gender = 1;
                        break;
                    default:
                        $gender = 1;
                    break;
                }

                $civil_status = trim($row[9]);

                foreach($civil_status_arr as $civil) {
                    if($civil_status == $civil[1][0]) {
                        $civil_status = $civil[0];
                    } else {
                        $civil_status = 0;
                    }
                }

                $birthdate = trim($row[10]);

                $citizenship = trim($row[11]);
                $citizenship_id = getField('num_code', 'countries', 'nationality LIKE "%'.$citizenship.'%"');
                $citizenship_id = checkVar($citizenship_id) ? $citizenship_id : 608; // Filipino default

                // suggested unit owner ID
                $sql = $pdo->prepare("SELECT id, unit_owner_id FROM unit_owners ORDER BY id DESC LIMIT 1");
                $sql->execute();
                $data = $sql->fetch(PDO::FETCH_ASSOC);
                if($data['unit_owner_id'] == '') {
                    $unit_owner_id_suggestion = '100001';
                } else {
                    $unit_owner_id_suggestion = $data['unit_owner_id'] + 1;
                }

                $upass = encryptStr($unit_owner_id_suggestion);

                $sql = $pdo->prepare("INSERT INTO `unit_owners` (
                    unit_owner_id, 
                    upass, 
                    firstname, 
                    middlename, 
                    lastname, 
                    gender, 
                    civil_status, 
                    birthdate, 
                    citizenship_id
                ) VALUES (
                    :unit_owner_id, 
                    :upass, 
                    :firstname, 
                    :middlename, 
                    :lastname, 
                    :gender, 
                    :civil_status, 
                    :birthdate, 
                    :citizenship_id
                )");
                $sql->bindParam(":unit_owner_id", $unit_owner_id_suggestion);
                $sql->bindParam(":upass", $upass);
                $sql->bindParam(":firstname", $firstname);
                $sql->bindParam(":middlename", $middlename);
                $sql->bindParam(":lastname", $lastname);
                $sql->bindParam(":gender", $gender);
                $sql->bindParam(":civil_status", $civil_status);
                $sql->bindParam(":birthdate", $birthdate);
                $sql->bindParam(":citizenship_id", $citizenship_id);
                $sql->execute();

                $unit_owner_id = $pdo->lastInsertId();

                $sql = $pdo->prepare("INSERT INTO units (
                    unit_name, 
                    unit_capacity,
                    property_id, 
                    sub_property_id,
                    unit_type,
                    unit_area,
                    unit_owner_id
                ) VALUES (
                    :unit_name,
                    :unit_capacity,
                    :property_id,
                    :sub_property_id,
                    :unit_type,
                    :unit_area,
                    :unit_owner_id
                )");
                $sql->bindParam(":property_id", $property_id);
                $sql->bindParam(":sub_property_id", $sub_property_id);
                $sql->bindParam(":unit_owner_id", $unit_owner_id);

                if($i >= $start && $i <= $end) {

                    // check unit name if existed
                    $exist = getField('id', 'units', 'unit_name = "'.$unit_name.'" AND sub_property_id = '.$sub_property_id);
                    if(empty($exist)) {
                        
                        $sql->bindParam(":unit_name", $unit_name);
                        $sql->bindParam(":unit_capacity", $unit_capacity);
                        $sql->bindParam(":unit_type", $unit_type);
                        $sql->bindParam(":unit_area", $unit_area);
                        $sql->execute();

                    }
                }
                $i++;
            }

            echo 'success';

        } else {
            echo 'error';
        }

    } else { // permission not found

		$_SESSION['sys_permission_err'] = renderLang($permission_message_1);
		echo 'invalid permission';

	}
} else { // no session found, redirect to login page

	$_SESSION['sys_login_err'] = renderLang($login_msg_err_4);
	echo 'no session';

}
?>