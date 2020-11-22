<?php
include __DIR__."/../../config.php";
if (!isset($_FILES['pm_image']['tmp_name'])) {
	}else{

	//Image
	$file=$_FILES['pm_image']['tmp_name'];
	$image= addslashes(file_get_contents($_FILES['pm_image']['tmp_name']));
	$image_name= addslashes($_FILES['pm_image']['name']);
			
	move_uploaded_file($_FILES["pm_image"]["tmp_name"],"pm-image/" . $_FILES["pm_image"]["name"]);

	//Icon
	$filei=$_FILES['pm_icon']['tmp_name'];
	$imagei= addslashes(file_get_contents($_FILES['pm_icon']['tmp_name']));
	$image_namei= addslashes($_FILES['pm_icon']['name']);
			
	move_uploaded_file($_FILES["pm_icon"]["tmp_name"],"../Assets/dashboard images/properties/icon/" . $_FILES["pm_icon"]["name"]);

	//gif
	$filej=$_FILES['pm_name_gif']['tmp_name'];
	$imagej= addslashes(file_get_contents($_FILES['pm_name_gif']['tmp_name']));
	$image_namej= addslashes($_FILES['pm_name_gif']['name']);
			
	move_uploaded_file($_FILES["pm_name_gif"]["tmp_name"],"../Assets/dashboard images/properties/icon/" . $_FILES["pm_name_gif"]["name"]);	

			$pm_image=$_FILES["pm_image"]["name"];
			$pm_icon=$_FILES["pm_icon"]["name"];
			$pm_name_gif=$_FILES["pm_name_gif"]["name"];
			$pm_name=$_POST['pm_name'];
			$pm_details=$_POST['pm_details'];

			
			$sql=mysqli_query($con,"INSERT INTO table_property_management (pm_image,pm_icon,pm_name_gif,pm_banner,pm_name,pm_details) VALUES ('$pm_image','$pm_icon','$pm_name_gif','$pm_banner','$pm_name','$pm_details')");
			header("location: ../dashboard/property.php?success");
			exit();					
	}
?>
