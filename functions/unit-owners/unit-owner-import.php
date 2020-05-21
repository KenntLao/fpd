<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if tenant has existing session
if(checkSession()) {

    $err = 0;

    $file_name = '';
    $file_ext = '';

    $file = '';
    if(isset($_FILES['unit_owner_file']['name'])) {

        $file = $_FILES['unit_owner_file']['name'];

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

    // start unit owner ID
		$sql = $pdo->prepare("SELECT id, unit_owner_id FROM unit_owners ORDER BY id DESC LIMIT 1");
		$sql->execute();
		$data = $sql->fetch(PDO::FETCH_ASSOC);
		if($data['unit_owner_id'] == '') {
			$unit_owner_id = '1001';
		} else {
			$unit_owner_id = $data['unit_owner_id'] + 1;
        }
        
        

    if($err == 0) {

        $handle = fopen($_FILES['unit_owner_file']['tmp_name'], "r");

        $start = 2;
        $end = 2000;
        $i = 1;

        while(($row = fgetcsv($handle)) !== false)
        {
            // default import - firstname - middlename - lastname - gender - civil status - birthdate - citizenship

            $upass = encryptStr($unit_owner_id);

            $firstname = trim($row[0]);
            $middlename = trim($row[1]);
            $lastname = trim($row[2]);

            $gender = trim($row[3]);
            if(strtolower($gender) == 'male') {
                $gender = 1;
            } else if(strtolower($gender) == 'female') {
                $gender = 0;
            }

            $civil_status = trim($row[4]);
            foreach($civil_status_arr as $status) {
                if(strcasecmp($status[1][0], $civil_status) == 0) {
                    $civil_status == $status[0];
                }
            }

            $birthdate = trim($row[5]);
            $citizenship = trim($row[6]);
            $citizenship_id = !empty($citizenship) ? getField('num_code', 'countries', 'nationality = "'.$citizenship.'"') : 0;

            $sql = $pdo->prepare("INSERT INTO unit_owners(
                id,
                unit_owner_id,
                upass,
                firstname,
                middlename,
                lastname,
                gender,
                civil_status,
                birthdate,
                citizenship_id
            ) VALUES(
                NULL,
                :unit_owner_id,
                :upass,
                :firstname,
                :middlename,
                :lastname,
                :gender,
                :civil_status,
                :birthdate,
                :citizenship
            )");

            if($i >= $start && $i <= $end) {

                $sql->bindParam(":unit_owner_id",$unit_owner_id);
                $sql->bindParam(":upass",$upass);
                $sql->bindParam(":firstname",$firstname);
                $sql->bindParam(":middlename",$middlename);
                $sql->bindParam(":lastname",$lastname);
                $sql->bindParam(":gender",$gender);
                $sql->bindParam(":civil_status",$civil_status);
                $sql->bindParam(":birthdate",$birthdate);
                $sql->bindParam(":citizenship", $citizenship_id);
                $sql->execute();

                $unit_owner_id++;

            }

            $i++;

        }

        echo 'success';

    } else {
        echo 'error';
    }

   

} else { // no session found, redirect to login page

	$_SESSION['sys_login_err'] = renderLang($login_msg_err_4);
	header('location: /');

}
?>