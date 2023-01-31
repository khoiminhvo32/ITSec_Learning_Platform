<?php
session_start();
if(!isset($_SESSION["email_username"])){
    die(header("location: login-email.php"));
}

include "static/html/email.html";
?>