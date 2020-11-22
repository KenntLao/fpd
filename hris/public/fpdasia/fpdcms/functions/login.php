<?php
session_start();
include('config.php');


if(isset($_POST["login"])) 
{
$username=mysqli_real_escape_string($con,$_POST['username']);
$password=md5(mysqli_real_escape_string($con,$_POST['password']));
$sql = "SELECT * from table_admin where username ='$username' and password ='$password' LIMIT 1";
	$result = mysqli_query($con, $sql);
	$fetch = mysqli_fetch_array($result);
	if($fetch) {
            $id= $fetch["id"];
			$role= $fetch["role"];

            create_cookie('idname',$id);
            create_cookie('role',$role);
			
			if(!empty($_POST["remember"])) {
				setcookie ("user_login",$_POST["username"],time()+ (10 * 365 * 24 * 60 * 60));
				setcookie ("userpassword",$_POST["password"],time()+ (10 * 365 * 24 * 60 * 60));
			} else {
				if(isset($_COOKIE["user_login"])) {
					setcookie ("user_login","");
				}
				if(isset($_COOKIE["userpassword"])) {
					setcookie ("userpassword","");

				}
			}

            if ($role=='Admin') {
                # code...
	           header('location: ../dashboard/index.php');
            } else if ($role=='HR') {
               header('location: ../dashboard/index.php');
            }else{
               header('location: ../dashboard/index.php');

            }

	} else {
	        header('location: ../login.php');
	}
}


?>