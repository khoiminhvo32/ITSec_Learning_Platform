<?php
session_start();
if (!isset($_SESSION['username']))
  die(header("location: forget_password.php"));

if (isset($_POST['button'])){
    try {
        include "./db.php";
        $sql = "update users set password = MD5(?) where username=?";
        $sth = $database->prepare($sql);
        $sth->bind_param('ss', $_POST['new_password'] ,$_POST['post_username']);
        $sth->execute();

        $result = $sth->affected_rows;

        if ($result != NULL) {
            $message = $result . " rows inserted.";
        } else {
            $message = "Something went wrong!!!";
        }
    } catch (mysqli_sql_exception $e) {
        $message = $e->getMessage();
    }   
}

include "static/html/update_password.php";
?>