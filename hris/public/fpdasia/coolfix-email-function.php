<?php
if(isset($_POST["submit_coolfix"])){

$to = "guiller.socialconz@gmail.com";
$subject = "Booking";
$from=$_POST["email_es"];
$number=$_POST["phone_es"];
$name=$_POST["name_es"];
$mssg=$_POST["message_es"];
$date=$_POST["date_es"];
$msg="	 Name: ".$name."  
	 Number: ".$number."  
	 Email: ".$from." 
	 Phone: ".$number."
	 Book Date(yy/mm/dd): ".$date."
	 Message:".$mssg."";

$headers = "From: $from";

mail($to,$subject,$msg,$headers);
header("location: services-engineer.php?success2");

}
?>