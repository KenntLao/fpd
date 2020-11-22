<?php

$link = mysqli_connect('fpdasianet1.powwebmysql.com', 'fpdasia', '1234'); 
if (!$link) { 
    die('Could not connect: ' . mysqli_error()); 
} 
mysqli_select_db(fpdasia_db);

// cookie functions
function create_cookie($name, $value) {
setcookie($name, $value, time() + (86400), '/', $_SERVER['SERVER_NAME'], false, true); // 86400 = 1 day (3 months exp.)
}

?>