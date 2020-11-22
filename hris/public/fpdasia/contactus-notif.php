     <?php
if(isset($_POST["contact_submit"])){

$to = "socialconz@gmail.com, inquiry@fpdasia.net";
$subject = "Inquiry Mail";
$from=$_POST["contact_email"];
$number=$_POST["contact_tel"];
$msg=$_POST["contact_name"];
$contact_msg=$_POST["contact_msg"];
$msg="name: ".$msg."  Number: ".$number."  Email: ".$from." Message: ".$contact_msg."";
$headers = "From: $from";

mail($to,$subject,$msg,$headers);
header("location: contactus.php?success");

}
?>