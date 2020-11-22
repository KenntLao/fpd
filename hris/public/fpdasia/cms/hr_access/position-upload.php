<?php
include __DIR__."/../config.php";
 if ($_COOKIE['role']!='HR') {
    header('location: ../login.php');
  }
    if(empty($_COOKIE['idname'])) { 
       header('location: ../login.php');
     }
  
if (!isset($_FILES['job_image']['tmp_name'])) {
	}else{
	$file=$_FILES['job_image']['tmp_name'];
	$image= addslashes(file_get_contents($_FILES['job_image']['tmp_name']));
	$image_name= addslashes($_FILES['job_image']['name']);
			
			move_uploaded_file($_FILES["job_image"]["tmp_name"],"../admin/careers/job-image/" . $_FILES["job_image"]["name"]);

	$filei=$_FILES['job_icon']['tmp_name'];
	$imagei= addslashes(file_get_contents($_FILES['job_icon']['tmp_name']));
	$image_namei= addslashes($_FILES['job_icon']['name']);
			
			move_uploaded_file($_FILES["job_icon"]["tmp_name"],"../admin/careers/job-icon/" . $_FILES["job_icon"]["name"]);
			
			$job_image=$_FILES["job_image"]["name"];
			$job_icon=$_FILES["job_icon"]["name"];
			$job_name=$_POST['job_name'];
			$job_details=$_POST['job_details'];
			$job_identification=$_POST['job_identification'];
			$job_specification=$_POST['job_specification'];
			$job_duty_respo=$_POST['job_duty_respo'];
			
			$sql=mysqli_query($con,"INSERT INTO table_job (job_image,job_icon, job_name,job_details,job_identification,job_specification,job_duty_respo) VALUES ('$job_image','$job_icon','$job_name','$job_details','$job_identification','$job_specification','$job_duty_respo')");

			
}
?>
<script >
	window.location.href='careers.php';
</script>

