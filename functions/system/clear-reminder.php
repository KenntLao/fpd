<?php 
session_start();

$key = $_POST['key'];
unset($_SESSION['sys_reminder_code'][$key]);
?>