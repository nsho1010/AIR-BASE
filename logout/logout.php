<?php
session_start();
// var_dump($_SESSION);
// exit();
$_SESSION = array();
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 5, '/');
}


session_destroy();


header('Location:../login/loginTop.php');
exit();
