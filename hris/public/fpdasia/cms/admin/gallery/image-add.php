<?php
include __DIR__."/../../config.php";
$addimg_id=$_GET['gallery_id'];
$result = mysqli_query($con,"SELECT * FROM table_gallery_images WHERE image_deleted IS NULL and gallery_id=$addimg_id") or die(mysqli_error());
	$fetch=mysqli_fetch_assoc($result);
		if(isset($_POST['add_image'])) {


if (!isset($_FILES['images']['tmp_name'])) {
	}else{
	$file=$_FILES['images']['tmp_name'];
	$images= addslashes(file_get_contents($_FILES['images']['tmp_name']));
	$images_name= addslashes($_FILES['images']['name']);
			
			move_uploaded_file($_FILES["images"]["tmp_name"],"gallery/" . $_FILES["images"]["name"]);
			
			$images="gallery/" . $_FILES["images"]["name"];
	
			
			$sql=mysqli_query($con,"INSERT INTO table_gallery_images (images,gallery_id) VALUES ('$images','$addimg_id')");
			echo $sql;
			header("location: gallery-edit.php?gallery_id=$addimg_id");
			exit();					
	}
}
?>
