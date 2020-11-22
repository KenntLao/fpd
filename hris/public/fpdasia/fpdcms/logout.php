
<?php
session_start();
setcookie('idname', '', time() - (86400 + 1), '/', $_SERVER['SERVER_NAME'], false, true);
setcookie('role', '', time() - (86400 + 1), '/', $_SERVER['SERVER_NAME'], false, true);
?>
<script >
	window.location.href='login.php';
</script>