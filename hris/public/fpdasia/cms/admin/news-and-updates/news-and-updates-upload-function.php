<?php
include __DIR__."/../../config.php";

 if ($_COOKIE['role']!='Marketing' || $_COOKIE['role']!='Admin') {
    header('location: ../../login.php');
  }
    if(empty($_COOKIE['idname'])) { 
      header('location: ../../login.php');
  }

if (!isset($_FILES['nu_image']['tmp_name'])) {
	}else{
	$file=$_FILES['nu_image']['tmp_name'];
	$image= addslashes(file_get_contents($_FILES['nu_image']['tmp_name']));
	$image_name= addslashes($_FILES['nu_image']['name']);
			
			move_uploaded_file($_FILES["nu_image"]["tmp_name"],"news-and-updates/" . $_FILES["nu_image"]["name"]);
			
			$nu_image=$_FILES["nu_image"]["name"];
			$nu_name=$_POST['nu_name'];
			$nu_details=$_POST['nu_details'];
			$nu_short_details=$_POST['nu_short_details'];
			$nu_date=$_POST['nu_date'];
			$nu_link=$_POST['nu_link'];
			$nu_name_link=$_POST['nu_name_link'];
			$nu_category=$_POST['nu_category'];
			
			$sql=mysqli_query($con,"INSERT INTO table_news_and_updates (nu_image, nu_name,nu_date, nu_details, nu_category) VALUES ('$nu_image','$nu_name','$nu_date','$nu_details','$nu_category')");


			if ($_COOKIE['role']=='Admin') {

			header("location: news-and-updates.php?success");
			exit();					
			}
			else{

			header("location: ../../marketing_access/news-and-updates/news-and-updates.php?success");
			exit();

			}
	}
?>
