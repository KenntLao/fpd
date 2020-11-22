<?php
include __DIR__."/config.php";

 if ($_COOKIE['role']!='Marketing' || $_COOKIE['role']!='Admin') {
    header('location: ../login.php');
  }
    if(empty($_COOKIE['idname'])) { 
      header('location: ../login.php');
  }

if (!isset($_FILES['c_icon']['tmp_name'])) {
	}else{
	$file=$_FILES['c_icon']['tmp_name'];
	$image= addslashes(file_get_contents($_FILES['c_icon']['tmp_name']));
	$image_name= addslashes($_FILES['c_icon']['name']);
			
			move_uploaded_file($_FILES["c_icon"]["tmp_name"],"../Assets/dashboard images/coolfix/" . $_FILES["c_icon"]["name"]);
			
			$c_icon=$_FILES["c_icon"]["name"];
			$c_name=$_POST['c_name'];
			$c_description=$_POST['c_description'];

			
			$sql=mysqli_query($con,"INSERT INTO table_coolfix (c_icon, c_name,c_description) VALUES ('$c_icon','$c_name','$c_description')");

			header("location: ../dashboard/services-coolfix.php?success");
			exit();					

	}
?>
