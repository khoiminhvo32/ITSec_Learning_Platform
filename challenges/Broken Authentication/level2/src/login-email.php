<?php
session_start();
if (isset($_POST["email"]) && isset($_POST["password"])) {
    try {
        include "./db.php";
        $sql = "select username from users where email=? and password=MD5(?)";
        $sth = $database->prepare($sql);
        $sth->bind_param('ss', $_POST['email'], $_POST['password']);
        $sth->execute();
        $sth->store_result();
        $sth->bind_result($result);

        if ($sth->num_rows > 0) {
            $sth->fetch();
            $_SESSION["email_username"] = $result;
            die(header("location: email.php"));
        } else {
            $message = "Wrong email or password";
        }
    } catch (mysqli_sql_exception $e) {
        $message = $e->getMessage();
    }   
}
include "static/html/login-email.html";
