<?php
// Created by MinKhoy
if(isset($_POST['sub'])){
	try {
		$whitelist_number = range(1,2000);
		$whitelist_sub = array("+","-","*","/");

		$num1 = $_POST['num1'];
		$num2 = $_POST['num2'];
		$sub = $_POST['sub'];

		if (in_array($num1, $whitelist_number) && in_array($num2, $whitelist_number) && in_array($sub, $whitelist_sub)) {
			$cal = "$num1 $sub $num2";
			// echo $cal;
			$evalCal = "return $cal;";
			// echo "[+] DEBUG: " . $evalCal;
			$result = eval($evalCal);
		} else {
			$result = "Number or operators not supported";
		}
	} catch(Exception $e) {
		echo "Something went wrong";
		echo "Error: " . $e->getMessage();
	}
}
include "./static/index.html";
?>