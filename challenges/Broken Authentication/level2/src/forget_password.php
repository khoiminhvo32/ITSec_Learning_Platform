<?php
session_start();
if (isset($_POST['button'])){
    try {
        include "./db.php";
        $sql = "select username from users where username=?";
        $sth = $database->prepare($sql);
        $sth->bind_param('s', $_POST['username']);
        $sth->execute();
        $sth->store_result();
        $sth->bind_result($result);

        if ($sth->num_rows > 0) {
            $sth->fetch();
            $_SESSION["username"] = $result;
            die(header("location: 2fa-code.php"));
        } else {
            $message = "Username doesn't exist";
        }
    } catch (mysqli_sql_exception $e) {
        $message = $e->getMessage();
    }   
}

include "static/html/forget_password.html";
?>