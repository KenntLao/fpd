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

            if ($role=='Admin' || $role=='HR') {
                # code...
	           header('location: admin/dashboard.php');
            } else{
               header('location: marketing_access/news-and-updates/news-and-updates.php');

            }

	} else {
		$message = "Invalid Login";
	}
}


?>

<!DOCTYPE html>
<html>
<head>
		<link rel="shortcut icon" href="../Gallery of Website/Logo/Company Logo.png" />
		<title>FPD Asia Property Services, Inc.</title>

	<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">
<link rel="stylesheet" type="text/css" href="login.css">
</head>
<body>

<div class="container">
<div class="card card-login mx-auto text-center bg-light" style="margin-top: 9%;">
    
    <div class="card-header mx-auto">
        <span><img src="../Assets/FPD-Logo.png" class="w-50" alt="Logo"></span><br/>
            <span class="logo_title mt-5">Login Dashboard</span>
                <p class="text-danger"><?php if(isset($message)) { echo $message; } ?></p>
    </div>

    <div class="card-body">
        <form action="" method="post">

        <div class="input-group form-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
            </div>
            <input name="username" type="text" value="<?php if(isset($_COOKIE["user_login"])) { echo $_COOKIE["user_login"]; } ?>" class="form-control" placeholder="Username">
        </div>

        <div class="input-group form-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-key"></i></span>
            </div>
            <input name="password" type="password" value="<?php if(isset($_COOKIE["userpassword"])) { echo $_COOKIE["userpassword"]; } ?>" class="form-control" placeholder="Password">
        </div>

        <div class="row align-items-center remember">
            <input type="checkbox" name="remember" <?php if(isset($_COOKIE["user_login"])) { ?> checked <?php } ?>>
            <span class="text-danger">Remember Me</span>
		</div>


        <div class="form-group">
            <input type="submit" name="login" value="Login" class="btn btn-outline-danger float-right login_btn">
        </div>

        </form>
    </div>
</div>
</div>

</body>
</html>