<?php
include __DIR__."/../config.php";

if ($_COOKIE['role']!='Admin') {
    header('location: ../../login.php');
  }

    if(empty($_COOKIE['idname'])) { 
       header('location: ../login.php');
     }

if (isset($_GET['job_id'])) {

$job_id = $_GET['job_id'];

$query1 = "SELECT * FROM table_job WHERE job_id = '$job_id'";
$result1 = mysqli_query ($con, $query1);

while ($row = mysqli_fetch_array($result1)) {
    $enabled = $row ["enabled"];

}

if ($enabled == 'enabled') {
    $enabled = 'disabled';
} else {
    $enabled = 'enabled';
}
echo $enabled;

    $query1 = "UPDATE table_job SET enabled = '$enabled'
                WHERE job_id = '$job_id'";              
    mysqli_query ($con,$query1);
}
header('location: careers.php')

?>