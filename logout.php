<?php
//session
session_start();
//unset all session variables
$_SESSION = array();
//destroy the session cookie
if (isset($_COOKIE[session_name()])) {
	setcookie(session_name(), '', time()-42000, '/');
}
//destroy session
session_destroy();

header("Location: login.php");




?>