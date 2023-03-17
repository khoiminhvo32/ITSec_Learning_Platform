<?php
function checkValid($data)
{
  if (strpos($data, "'") !== false)
    return false;
  return true;
}

if (isset($_POST["username"]) && isset($_POST["password"])) {
  try {
    $username = $_POST["username"];
    $password = $_POST["password"];
    if (checkValid($username) && checkValid($password)) {
      
      include "db.php";
      $sql = "SELECT username FROM users WHERE username='$username' AND password=MD5('$password')";
      $db_result = $database->query($sql);
      if ($db_result->num_rows > 0) {
        $row = $db_result->fetch_assoc();
        if ($row['username'] === "admin") {
          $message = "ow you can log in as admin, here is your flag <b>VIS{Room_EsCapinG..}</b>";
        } else
          $message = "You logged in, but then what? You are not an admin";
      } else {
        $message = "Wrong username or password";
      }
    } else {
      $message = "Hack detected";
    }
  } catch (mysqli_sql_exception $e) {
    $message = $e->getMessage();
  }
}
include "static/html/login.html";
