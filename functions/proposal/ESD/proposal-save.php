<?php
// INCLUDES
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

// check if user has existing session
if(checkSession()) {

	// check permission to access this page or function
	if(checkPermission('proposal-esd-edit')) {

        $err = 0;

        $prospect_id = 0;
        if(isset($_POST['prospect_id'])) {
            $prospect_id = $_POST['prospect_id'];
        }

        // Letter
            $honorific = '';
            if(isset($_POST['honorific'])) {
                $honorific = trim($_POST['honorific']);
            }

            $service = '';
            if(isset($_POST['service'])) {
                $service = trim($_POST['service']);
            }

            $location = '';
            if(isset($_POST['location'])) {
                $location = trim($_POST['location']);
            }

            $days = '';
            if(isset($_POST['days'])) {
                $days = trim($_POST['days']);
            }

            $service_fee = '';
            if(isset($_POST['service_fee'])) {
                $service_fee = trim($_POST['service_fee']);
            }

            $term_of_payment = '';
            if(isset($_POST['term_of_payment'])) {
                $term_of_payment = trim($_POST['term_of_payment']);
            }

            $fax_number = '';
            if(isset($_POST['fax_number'])) {
                $fax_number = trim($_POST['fax_number']);
            }

            $email = '';
            if(isset($_POST['email'])) {
                $email = trim($_POST['email']);
            }

            $author = '';
            if(isset($_POST['author'])) {
                $author = trim($_POST['author']);
            }

            $notes = '';
            if(isset($_POST['notes'])) {
                $notes = trim($_POST['notes']);
            }

            $noted_by = '';
            if(isset($_POST['noted_by'])) {
                $noted_by = trim($_POST['noted_by']);
            }

            $conforme = '';
            if(isset($_POST['conforme'])) {
                $conforme = trim($_POST['conforme']);
            }

            $contact_number = '';
            if(isset($_POST['contact_number'])) {
                $contact_number = trim($_POST['contact_number']);
            }
        // 

        // Services

            $date = '';
            if(isset($_POST['date'])) {
                $date = trim($_POST['date']);
            }

            $subject = '';
            if(isset($_POST['subject'])) {
                $subject = trim($_POST['subject']);
            }

            $service_honorifics = '';
            if(isset($_POST['service_honorifics'])) {
                $service_honorifics = trim($_POST['service_honorifics']);
            }

            $prepared_by = '';
            if(isset($_POST['prepared_by'])) {
                $prepared_by = trim($_POST['prepared_by']);
            }

            $service_noted_by = '';
            if(isset($_POST['service_noted_by'])) {
                $service_noted_by = trim($_POST['service_noted_by']);
            }

            // service area

                $service_area_id = array();
                if(isset($_POST['service_area_id'])) {
                    $service_area_id = $_POST['service_area_id'];
                }

                $quantity = array();
                if(isset($_POST['quantity'])) {
                    $quantity = $_POST['quantity'];
                }
            
                $description = array();
                if(isset($_POST['description'])) {
                    $description = $_POST['description'];
                }

                $service_location = array();
                if(isset($_POST['service_location'])) {
                    $service_location = $_POST['service_location'];
                }

                $unit_price = array();
                if(isset($_POST['unit_price'])) {
                    $unit_price = $_POST['unit_price'];
                }
                
                $total_price = array();
                if(isset($_POST['total_price'])) {
                    $total_price = $_POST['total_price'];
                }
                
            // 

        // 

        if($err == 0) {
            
            // save proposal
                $proposal_id = 0;
                $sql = $pdo->prepare("SELECT * FROM proposals WHERE prospect_id = :prospect_id LIMIT 1");
                $sql->bindParam(":prospect_id", $prospect_id);
                $sql->execute();
                if($sql->rowCount()) { // update

                    $data = $sql->fetch(PDO::FETCH_ASSOC);
                    $proposal_id = $data['id'];

                    $sql1 = $pdo->prepare("UPDATE proposals SET 
                        attachment = :attachment
                    WHERE id = :proposal_id");

                    $sql1->bindParam(":proposal_id", $proposal_id);
                    
                    // attachments
                    $attachment_arr = array();
                    $attachment_count = count($_FILES['attachment']);

                    for($i = 0; $i < $attachment_count; $i++) {

                        // check if directory existed if not create
                        if(!is_dir($sys_upload_dir.'proposals')) {
                            mkdir($sys_upload_dir.'proposals', 0755, true);
                        }

                        if(!empty($_FILES['attachment']['name'][$i])) {
        
                            $file = explode('.', $_FILES['attachment']['name'][$i]);
                            $file_name = $file[0];
                            $file_ext = $file[1];
            
                            $time = time();
            
                            $attachment_name = $file_name.'-'.$time.'.'.$file_ext;
            
                            $file_tmp = $_FILES['attachment']['tmp_name'][$i];
                            $file_size = $_FILES['attachment']['size'][$i];
                            
                            // save file
                            move_uploaded_file($file_tmp, $sys_upload_dir.'proposals/'.$attachment_name);
        
                            // push attachment name
                            $attachment_arr[] = $attachment_name;
                            
                        }
        
                    }

                    if(!empty($attachment_arr)) {
                        $attachment_name = implode(',', $attachment_arr);
                    } else {
                        $attachment_name = $data['attachment'];
                    }

                    $sql1->bindParam(":attachment", $attachment_name);
                    $sql1->execute();


                } else { // insert

                    $sql1 = $pdo->prepare("INSERT INTO proposals (
                        prospect_id, 
                        attachment 
                    ) VALUES (
                        :prospect_id,
                        :attachment
                    )");
                    $sql1->bindParam(":prospect_id", $prospect_id);
                    
                    // attachments
                    $attachment_arr = array();
                    $attachment_count = count($_FILES['attachment']);

                    for($i = 0; $i < $attachment_count; $i++) {

                        // check if directory existed if not create
                        if(!is_dir($sys_upload_dir.'proposals')) {
                            mkdir($sys_upload_dir.'proposals', 0755, true);
                        }

                        if(!empty($_FILES['attachment']['name'][$i])) {
        
                            $file = explode('.', $_FILES['attachment']['name'][$i]);
                            $file_name = $file[0];
                            $file_ext = $file[1];
            
                            $time = time();
            
                            $attachment_name = $file_name.'-'.$time.'.'.$file_ext;
            
                            $file_tmp = $_FILES['attachment']['tmp_name'][$i];
                            $file_size = $_FILES['attachment']['size'][$i];
                            
                            // save file
                            move_uploaded_file($file_tmp, $sys_upload_dir.'proposals/'.$attachment_name);
        
                            // push attachment name
                            $attachment_arr[] = $attachment_name;
                            
                        }
        
                    }

                    if(!empty($attachment_arr)) {
                        $attachment_name = implode(',', $attachment_arr);
                    } else {
                        $attachment_name = '';
                    }

                    $sql1->bindParam(":attachment", $attachment_name);
                    $sql1->execute();

                    $proposal_id = $pdo->lastInsertId();

                }
            // 

            // save proposal letter

                $sql = $pdo->prepare("SELECT * FROM proposal_letter WHERE proposal_id = :proposal_id LIMIT 1");
                $sql->bindParam(":proposal_id", $proposal_id);
                $sql->execute();
                if($sql->rowCount()) { // update
                    
                    $data = $sql->fetch(PDO::FETCH_ASSOC);
                    $letter_id = $data['id'];

                    $sql1 = $pdo->prepare("UPDATE proposal_letter SET 
                        honorifics = :honorific, 
                        services = :services, 
                        location = :location, 
                        days = :days, 
                        service_fee = :service_fee, 
                        term_of_payment = :term_of_payment, 
                        fax_number = :fax_number, 
                        email = :email, 
                        notes = :notes, 
                        author = :author, 
                        noted_by = :noted_by, 
                        conforme = :conforme, 
                        contact_no = :contact_no 
                    WHERE id = :letter_id");
                    $sql1->bindParam(":letter_id", $letter_id);
                    $sql1->bindParam(":honorific", $honorific);
                    $sql1->bindParam(":services", $service);
                    $sql1->bindParam(":location", $location);
                    $sql1->bindParam(":days", $days);
                    $sql1->bindParam(":service_fee", $service_fee);
                    $sql1->bindParam(":term_of_payment", $term_of_payment);
                    $sql1->bindParam(":fax_number", $fax_number);
                    $sql1->bindParam(":email", $email);
                    $sql1->bindParam(":notes", $notes);
                    $sql1->bindParam(":author", $author);
                    $sql1->bindParam(":noted_by", $noted_by);
                    $sql1->bindParam(":conforme", $conforme);
                    $sql1->bindParam(":contact_no", $contact_number);
                    $sql1->execute();

                } else { // insert

                    $sql1 = $pdo->prepare("INSERT INTO proposal_letter (
                        proposal_id, 
                        honorifics, 
                        services, 
                        location, 
                        days, 
                        service_fee, 
                        term_of_payment, 
                        fax_number, 
                        email, 
                        notes, 
                        author, 
                        noted_by, 
                        conforme,
                        contact_no
                    ) VALUES (
                        :proposal_id, 
                        :honorific, 
                        :services, 
                        :location, 
                        :days, 
                        :service_fee, 
                        :term_of_payment, 
                        :fax_number, 
                        :email, 
                        :notes, 
                        :author, 
                        :noted_by, 
                        :conforme, 
                        :contact_no
                    )");
                    $sql1->bindParam(":proposal_id", $proposal_id);
                    $sql1->bindParam(":honorific", $honorific);
                    $sql1->bindParam(":services", $service);
                    $sql1->bindParam(":location", $location);
                    $sql1->bindParam(":days", $days);
                    $sql1->bindParam(":service_fee", $service_fee);
                    $sql1->bindParam(":term_of_payment", $term_of_payment);
                    $sql1->bindParam(":fax_number", $fax_number);
                    $sql1->bindParam(":email", $email);
                    $sql1->bindParam(":notes", $notes);
                    $sql1->bindParam(":author", $author);
                    $sql1->bindParam(":noted_by", $noted_by);
                    $sql1->bindParam(":conforme", $conforme);
                    $sql1->bindParam(":contact_no", $contact_number);
                    $sql1->execute();

                }

            // 

            // save proposal services 
                $service_id = 0;
                $sql = $pdo->prepare("SELECT * FROM proposal_services WHERE proposal_id = :proposal_id LIMIT 1");
                $sql->bindParam(":proposal_id", $proposal_id);
                $sql->execute();
                if($sql->rowCount()) { // update

                    $data = $sql->fetch(PDO::FETCH_ASSOC);
                    $service_id = $data['id'];
                    
                    $sql1 = $pdo->prepare("UPDATE proposal_services SET 
                        date = :date, 
                        subject = :subject, 
                        honorifics = :honorifics, 
                        prepared_by = :prepared_by, 
                        checked_by = :checked_by 
                    WHERE id = :service_id");
                    $sql1->bindParam(":service_id", $service_id);
                    $sql1->bindParam(":date", $date);
                    $sql1->bindParam(":subject", $subject);
                    $sql1->bindParam(":honorifics", $service_honorifics);
                    $sql1->bindParam(":prepared_by", $prepared_by);
                    $sql1->bindParam(":checked_by", $service_noted_by);
                    $sql1->execute();

                } else { // insert

                    $sql1 = $pdo->prepare("INSERT INTO proposal_services (
                        proposal_id, 
                        date, 
                        subject, 
                        honorifics, 
                        prepared_by, 
                        checked_by
                    ) VALUES (
                        :proposal_id, 
                        :date, 
                        :subject, 
                        :honorifics, 
                        :prepared_by, 
                        :checked_by
                    )");
                    $sql1->bindParam(":proposal_id", $proposal_id);
                    $sql1->bindParam(":date", $date);
                    $sql1->bindParam(":subject", $subject);
                    $sql1->bindParam(":honorifics", $service_honorifics);
                    $sql1->bindParam(":prepared_by", $prepared_by);
                    $sql1->bindParam(":checked_by", $service_noted_by);
                    $sql1->execute();

                    $service_id = $sql1->lastInsertId();

                }
            
            // 

            // save proposal service area
                foreach($service_area_id as $key => $area_id) {

                    $sql = $pdo->prepare("SELECT * FROM proposal_service_area WHERE id = :area_id AND service_id = :service_id");
                    $sql->bindParam(":area_id", $area_id);
                    $sql->bindParam(":service_id", $service_id);
                    $sql->execute();
                    if($sql->rowCount()) { // update

                        $data = $sql->fetch(PDO::FETCH_ASSOC);

                        $sql1 = $pdo->prepare("UPDATE proposal_service_area SET 
                            quantity = :quantity, 
                            description = :description, 
                            location = :location, 
                            unit_price = :unit_price, 
                            total_price = :total_price 
                        WHERE id = :area_id");
                        $sql1->bindParam(":area_id", $area_id);
                        $sql1->bindParam(":quantity", $quantity[$key]);
                        $sql1->bindParam(":description", $description[$key]);
                        $sql1->bindParam(":location", $service_location[$key]);
                        $sql1->bindParam(":unit_price", $unit_price[$key]);
                        $sql1->bindParam(":total_price", $total_price[$key]);
                        $sql1->execute();

                    } else { // insert

                        $sql1 = $pdo->prepare("INSERT INTO proposal_service_area (
                            service_id, 
                            quantity, 
                            description, 
                            location,
                            unit_price, 
                            total_price
                        ) VALUES (
                            :service_id, 
                            :quantity, 
                            :description, 
                            :location, 
                            :unit_price, 
                            :total_price
                        )");

                        $sql1->bindParam(":service_id", $service_id);
                        $sql1->bindParam(":quantity", $quantity[$key]);
                        $sql1->bindParam(":description", $description[$key]);
                        $sql1->bindParam(":location", $service_location[$key]);
                        $sql1->bindParam(":unit_price", $unit_price[$key]);
                        $sql1->bindParam(":total_price", $total_price[$key]);
                        if(empty($quantity[$key]) && empty($description[$key]) && empty($service_location[$key]) && empty($unit_price[$key]) && empty($total_price[$key])) {
                            
                        } else {
                            $sql1->execute();
                        }
                        

                    }

                }
                
            // 

            $_SESSION['sys_proposal_edit_suc'] = renderLang($proposals_updated);
            header('location: /edit-esd-proposal/'.$prospect_id);

        } else {

            $_SESSION['sys_proposal_edit_err'] = renderLang($form_error);
            header('location: /edit-esd-proposal/'.$prospect_id);

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