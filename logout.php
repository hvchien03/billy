<?php
session_start();
unset($_SESSION['logged_user']);
unset($_SESSION['logged_username']);
header("location: index.php");
exit;
?>