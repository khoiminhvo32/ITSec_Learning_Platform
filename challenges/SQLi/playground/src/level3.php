<?php
if (isset($_POST["username"]) && isset($_POST["password"])) {
  try {
    include "db.php";
    $sql = "SELECT username FROM users WHERE username=\"" . $_POST["username"] . "\" AND password=MD5(\"" . $_POST["password"] . "\")";
    $db_result = $database->query($sql);
    if ($db_result->num_rows > 0) {
      $row = $db_result->fetch_assoc(); // Get the first row
      $username = $row["username"];
      if ($username === "admin") {
        $message = "Wow you can log in as admin, but I want to get all the information of users..";
      } else
        $message = "You log in as $username, but then what? You still don't have any info of users's table";
    } else {
      $message = "Wrong username or password";
    }
  } catch (mysqli_sql_exception $e) {
    $message = $e->getMessage();
  }
}
include "static/html/login.html";
