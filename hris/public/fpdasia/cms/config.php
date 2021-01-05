<?php

$host = "localhost";    /* Host name */
$user = "root";         /* User */
$password = "";         /* Password */
$dbname = "pms_db";   /* Database name */

$con = mysqli_connect($host, $user, $password) or die("Unable to connect");

// selecting database
$db = mysqli_select_db($con, $dbname) or die("Database not found");

// cookie functions
function create_cookie($name, $value) {
setcookie($name, $value, time() + (86400), '/', $_SERVER['SERVER_NAME'], false, true); // 86400 = 1 day (3 months exp.)
}
echo 1;
?>