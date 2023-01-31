<?php
session_start();
if (!isset($_SESSION['username']))
  die(header("location: forget_password.php"));

if (isset($_POST['btn-2fa'])){
    try {
        include "./db.php";
        $value = bin2hex(random_bytes(20));
        $_SESSION['2fa-value'] = $value;
    
        $insert = "INSERT INTO `2FA-code` VALUES (?, ?)";
        $sth = $database->prepare($insert);
        $sth->bind_param('ss', $_SESSION["username"] ,$value);
        $sth->execute();
    
        $result = $sth->affected_rows;
        if ($result != NULL) {
            $message_2FA = "Successfully create 2FA-code";
        } else {
            $message_2FA = "Something went wrong!!!";
        }
    } catch (mysqli_sql_exception $e) {
        $message_2FA = $e->getMessage();
    }   
}

if (isset($_POST['button'])){
    try {
        include "./db.php";
        $sql = "SELECT value FROM `2FA-code` WHERE username = ? and value = ?";
        $sth = $database->prepare($sql);
        $sth->bind_param('ss', $_SESSION['username'] ,$_POST['2FA-value']);
        $sth->execute();
        $sth->store_result();
        $sth->bind_result($result);

        if ($sth->num_rows > 0) {
            $sth->fetch();
            $message = "You have entered the right 2FA-code";
            die(header("location: update_password.php"));
        } else {
            $message = "Wrong 2FA-code";
        }
    } catch (mysqli_sql_exception $e) {
        $message = $e->getMessage();
    }   
}

include "static/html/2fa-code.php";
?>