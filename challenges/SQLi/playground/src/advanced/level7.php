<?php
session_start();
if (isset($_POST["username"]) && isset($_POST["password"])) {
    try {
        include "../db.php";
        $sql = "select username from users where username=? and password=?";
        $sth = $database->prepare($sql);
        $sth->bind_param('ss', $_POST['username'], $_POST['password']);
        $sth->execute();
        $sth->store_result();
        $sth->bind_result($result);

        if ($sth->num_rows > 0) {
            $sth->fetch();
            $_SESSION["username"] = $result;
            die(header("location: profile.php"));
        } else {
            $message = "Wrong username or password";
        }
    } catch (mysqli_sql_exception $e) {
        $message = $e->getMessage();
    }   
}

include "../static/html/second-order.html";
?>
