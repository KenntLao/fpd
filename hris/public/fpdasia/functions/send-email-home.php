<?php 

	require ("../includes/config.php");

	if ($_POST) {
		$err = 0;

		$name;
		if ($_POST['name'] !== '') {
			$name = $_POST['name'];
		}else{
			$err++;
		}

		$email;
		if ($_POST['email'] !== '') {
			$email = $_POST['email'];
		}else{
			$err++;
		}

		$number;
		if ($_POST['phone_number'] !== '') {
			$number = $_POST['phone_number'];
		}else{
			$err++;
		}

		if ($err == 0) {

			//send copy to FPD Asia
			$to = 'technical@socialconz.com';

			$subject = "New FPD Asia Contact";

			$message = "
				<div>Hello,</div></br>
				</br>
				<div>The client gave the following information:</div></br>
				</br>
				<div>Name: $name</div></br>
				<div>Email: $email</div></br>
				<div>Phone: $number</div></br>
				</br>
				<div>Regards,</div></br>
				<div>FPD Website</div>
			";

			$header = "From: FPD Asia Website <sender@fpdasia.socialconz.com>\r\nContent-type: text/html\r\n";

			mail($to, $subject, $message, $header);


			//send copy to client
			$to = $email;

			$subject = "Welcome to FPD Asia";

			$message = "
				<div>Hello $name,</div></br>
				</br>
				<div>Welcome to the family.</div></br>
				</br>
				<div>You have given the following infromation (rest assured that your privacy is protected):</div></br>
				</br>
				<div>Name: $name</div></br>
				<div>Email: $email</div></br>
				<div>Phone: $number</div></br>
				</br>
				<div>Regards,</div></br>
				<div>FPD Asia</div>
			";

			$header = "From: FPD Asia <sender@fpdasia.socialconz.com>\r\nContent-type: text/html\r\n";

			if (mail($to, $subject, $message, $header)) {
				header("Location: ../index.php?status=success");
			}

		}else{
			echo $err;
		}
	}



 ?>
 <div>Hello $name,</div>