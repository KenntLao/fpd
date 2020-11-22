<?php 
include __DIR__."/../config.php";

      if (isset($_POST['create_admin'])) {
      $username=$_POST['username'];
      $role=$_POST['role'];   
      $password=md5($_POST['password']);
      $sql =mysqli_query($con, "INSERT INTO table_admin ( username, role, password ) VALUES ('$username', '$role', '$password')");

 
      }
      header('location: create-admin.php?success');

       ?>