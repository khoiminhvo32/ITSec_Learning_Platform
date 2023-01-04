<?php
if (isset($_POST["username"]) && isset($_POST["password"])) {
  try {
    include "db.php";
    $sql = "SELECT username, password FROM users WHERE username='" . $_POST["username"] . "'";
    $db_result = $database->query($sql);
    if ($db_result->num_rows > 0) {
      $row = $db_result->fetch_assoc(); // Get the first row
      $password = $row["password"];
      if ($password === $_POST["password"]) {
        $username = $row["username"];
        if ($username === "admin") {
          $message = "Wow you can log in as admin, here is your flag CBJS{3fa996e38acc675ae51fef858dc35eb3}, but how about <a href='level5.php'>THIS LEVEL</a>!";
        } else
          $message = "You log in as $username, but then what? You are not an admin";
      } else
        $message = "Wrong username or password";
    } else {
      $message = "Username not found";
    }
  } catch (mysqli_sql_exception $e) {
    $message = $e->getMessage();
  }
}
include "static/html/login.html";
