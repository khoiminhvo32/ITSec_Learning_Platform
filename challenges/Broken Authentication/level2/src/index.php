<?php
if (isset($_POST["username"]) && isset($_POST["password"])) {
    try {
        include "./db.php";
        $sql = "select username from users where username=? and password=MD5(?)";
        $sth = $database->prepare($sql);
        $sth->bind_param('ss', $_POST['username'], $_POST['password']);
        $sth->execute();
        $sth->store_result();
        $sth->bind_result($result);

        if ($sth->num_rows > 0) {
            $sth->fetch();
            if ($result === "admin") {
                $message = "Wow you can log in as admin, here is your flag <b>VIS{Just_Ez_S3mi_P@ssw0rd_GueSsing}</b>";
            } else {
                $message = "You can login as $result, but then what? You are not an admin";
            }
        } else {
            $message = "Wrong username or password";
        }
    } catch (mysqli_sql_exception $e) {
        $message = $e->getMessage();
    }   
}
include "static/html/login.html";
