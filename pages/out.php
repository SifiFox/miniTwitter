<?php
if (session_status() != PHP_SESSION_ACTIVE) session_start();

unset($_SESSION["email"]);
unset($_SESSION["surname"]);
unset($_SESSION["firstname"]);
unset($_SESSION["password"]);

header("HTTP/1.1 301 Moved Permanently");
header("Location: ./auth.php");

?>