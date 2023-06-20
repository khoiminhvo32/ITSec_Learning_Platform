<?php

$username = "admin";
$hashed_password = "0e087386482136013740957780965291";
// if(isset($_GET['debug'])) die(highlight_file(__FILE__));
if(isset($_GET['forget_password'])) {
    $hint = "md5 passwd: " . $hashed_password;
}
$password = $_GET['password'];
// echo "Comparing: ".md5($_GET['password']). " == ". $hashed_password. "\n";
if( md5($password) == $hashed_password ){
    // echo "Welcome back ADMIN!\n";
    // echo "Here is your flag: "; 
    $flag = getenv("FLAG");
} else {
    $error = "Wrong password! no flag for you.";
}

include "./static/otp.html";
?>
