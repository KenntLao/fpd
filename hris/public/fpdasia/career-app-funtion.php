<?php
include __DIR__."/cms/config.php";
if (!isset($_FILES['careers_app_file']['tmp_name'])) {
	}else{

		$file=$_FILES['careers_app_file']['tmp_name'];
		$image= addslashes(file_get_contents($_FILES['careers_app_file']['tmp_name']));
		$image_name= addslashes($_FILES['careers_app_file']['name']);
			
			move_uploaded_file($_FILES["careers_app_file"]["tmp_name"],"../assets/files/candidates/candidates_file/" . $_FILES["careers_app_file"]["name"]);
			
			//, recruit_hr@fpdasia.net
			$career_app_file=$_FILES["careers_app_file"]["name"];
			$careers_app_fname=$_POST['careers_app_fname'];
			$careers_app_lname=$_POST['careers_app_lname'];
			$careers_app_email=$_POST['careers_app_email'];
			$careers_app_number=$_POST['careers_app_number'];
			$careers_app_gender=$_POST['careers_app_gender'];
			$careers_app_position=$_POST['careers_app_position'];
			$subject="You Have New Application";
			$to = "socialconz@gmail.com, guiller.socialconz@gmail.com, recruit_hr@fpdasia.net";
			$msg = "You Have New Applicants";
			$header="Hi Ms.Rona";

			mail($to,$subject,$msg,$header);

			if(!empty($careers_app_email)){

                // To send HTML mail, the Content-type header must be set
                $headers[] = "MIME-Version: 1.0";
                $headers[] = "Content-type: text/html; charset=iso-8859-1";

                // Additional headers
                $headers[] = "From: recruit_hr@fpdasia.net" ;
                $headers[] = "X-Mailer: PHP/" . phpversion();

                $applicant_header = "Hi $careers_app_fname $careers_app_lname.";
                $applicant_subject = "Thank you for application.";
                $applicant_msg = "
                            <html>
                                <head><title>Thank you for application.</title></head>
                                <body>
                                    <h4>Hi $careers_app_fname $careers_app_lname,</h4>
                                    </br>
                                    <p>Thank you for taking the time to submit your application. We appreciate your interest in FPD Asia Property Services Inc.</p>
                                    </br>
                                    <p>You will be contacted by our HR Officer in the event that your skills and experience matches the position you have applied for.</p>
                                    </br></br></br>
                                    <p>Regards,</p>
                                    <p>HRD</p>
                                </body>
                            </html>
                        ";
                mail($careers_app_email,$applicant_subject,$applicant_msg,implode("\r\n", $headers));
            }

			$sql=mysqli_query($con,"INSERT INTO table_careers_applications (careers_app_file ,careers_app_fname, careers_app_lname, careers_app_email, careers_app_number, careers_app_gender, careers_app_position , date_apply) VALUES ('$career_app_file','$careers_app_fname','$careers_app_lname','$careers_app_email','$careers_app_number','$careers_app_gender','$careers_app_position',now())");

		
			header('location: careers-application.php?sending_success');
			exit();					
	}
?>
