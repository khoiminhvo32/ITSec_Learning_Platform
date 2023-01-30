<?php
session_start();
if (isset($_POST['button'])){
    try {
        include "./db.php";
        $sql = "update users set password = ? where username=?";
        $sth = $database->prepare($sql);
        $sth->bind_param('ss', $_POST['new_password'] ,$_POST['username']);
        $sth->execute();
        $sth->store_result();
        $sth->bind_result($result);

        if ($sth->num_rows > 0) {
            $sth->fetch();
            echo "successful";
        } else {
            $message = "Username doesn't exist";
        }
    } catch (mysqli_sql_exception $e) {
        $message = $e->getMessage();
    }   
}

include "static/html/update_password.html";
?>