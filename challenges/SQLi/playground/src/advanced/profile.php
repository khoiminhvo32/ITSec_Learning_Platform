<?php
session_start();
include "../db.php";
if (!isset($_SESSION['username']))
  die(header("location: level7.php"));

$username = $_SESSION['username'];
if (isset($_POST['button'])) {
  try {
    $sql = "select email from users where username='$username'";
    $db_result = $database->query($sql);
  
    if ($db_result->num_rows > 0) {
      $row = $db_result->fetch_assoc();
      $message = $row['email'];
    }
  } catch (mysqli_sql_exception $e) {
    $message = $e->getMessage();
  }
}

include "../static/html/profile.html";
