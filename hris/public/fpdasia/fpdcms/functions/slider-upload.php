<?php
include __DIR__."/config.php";
if (!isset($_FILES['home_slider_image']['tmp_name'])) {
	echo "";
	}else{
	$file=$_FILES['home_slider_image']['tmp_name'];
	$image= addslashes(file_get_contents($_FILES['home_slider_image']['tmp_name']));
	$image_name= addslashes($_FILES['home_slider_image']['name']);
			
			move_uploaded_file($_FILES["home_slider_image"]["tmp_name"],"../Assets/dashboard images/slider/" . $_FILES["home_slider_image"]["name"]);
			
			$home_slider_image=$_FILES["home_slider_image"]["name"];
	
			$sql=mysqli_query($con,"INSERT INTO table_home_slider (home_slider_image) VALUES ('$home_slider_image')");
			header("location: ../dashboard/home.php?success");
			exit();					
	}
?>
