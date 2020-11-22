<?php
if(isset($_POST["submit_engineer"])){

$to = "guiller.socialconz@gmail.com";
$subject = "Ask for Details :".$_POST["details_es"]."";
$from=$_POST["email_es"];
$number=$_POST["phone_es"];
$name=$_POST["name_es"];
$msg="	 Name: ".$name."  
	 Number: ".$number."  
	 Email: ".$from." 
	 Phone: ".$number."
	 ".$subject."";

$headers = "From: $from";

mail($to,$subject,$msg,$headers);
header("location: services-engineer.php?success");

}
?>