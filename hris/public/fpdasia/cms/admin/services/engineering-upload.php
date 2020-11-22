<?php
include __DIR__."/../../config.php";

 if ($_COOKIE['role']!='Marketing' || $_COOKIE['role']!='Admin') {
    header('location: ../../login.php');
  }
    if(empty($_COOKIE['idname'])) { 
      header('location: ../../login.php');
  }

if (!isset($_FILES['es_icon']['tmp_name'])) {
	}else{
	$file=$_FILES['es_icon']['tmp_name'];
	$image= addslashes(file_get_contents($_FILES['es_icon']['tmp_name']));
	$image_name= addslashes($_FILES['es_icon']['name']);
			
			move_uploaded_file($_FILES["es_icon"]["tmp_name"],"engineering-image/" . $_FILES["es_icon"]["name"]);
			
			$es_icon=$_FILES["es_icon"]["name"];
			$es_name=$_POST['es_name'];
			$es_description=$_POST['es_description'];

			
			$sql=mysqli_query($con,"INSERT INTO table_engineering_services (es_icon, es_name,es_description) VALUES ('$es_icon','$es_name','$es_description')");

			header("location: engineering.php?success");
			exit();					

	}
?>
