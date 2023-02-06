<?php
session_start();
include "../db.php";
if (!isset($_SESSION['username']))
  die(header("location: level8.php"));

$username = $_SESSION['username'];
$email = $_POST['email'];
if ($username == 'admin') 
  $message = "<h3><b>Wow you can finally log in as admin, here is your flag VIS{N0t_0nly_aBout_SElect}</b></h3>";

if (isset($_POST['button'])) {
  try {
    $sql = "update users set email='$email' where username='$username'";
    $db_result = $database->query($sql);
    if ($db_result) {
      $message = "Successfully update your Email";
    } else {
      $message = "Failed to update your email";
    }
  } catch (mysqli_sql_exception $e) {
    $message = $e->getMessage();
  }
}

include "../static/html/update.html";
