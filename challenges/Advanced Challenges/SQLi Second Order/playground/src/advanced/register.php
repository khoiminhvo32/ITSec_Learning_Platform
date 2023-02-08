<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        include "../db.php";
        $sql = "select username from users where username=?";
        $sth = $database->prepare($sql);
        $sth->bind_param('s', $_POST['username']);
        $sth->execute();
        $sth->store_result();
        if ($sth->num_rows() > 0) {
            $message = "Sorry this username already registered";
        } else {
            $sql = "insert into users(username, password, email) values (?, ?, ?)";
            $sth = $database->prepare($sql);
            $sth->bind_param('sss', $_POST['username'], $_POST['password'], $_POST['email']);
            $sth->execute();
            $message = "Create successful";
        }
    } catch (mysqli_sql_exception $e) {
        $message = $e->getMessage();
    }
}

include "../static/html/register.html";
