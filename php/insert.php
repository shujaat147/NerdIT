<?php
// This file is connected to regiester.php
// conn file
include 'config.php';

// post is used to get values from the form
$fname = $_POST["fname"];
$lname = $_POST["lname"];
$address = $_POST["address"];
$city = $_POST["city"];
$pin = $_POST["pin"];
$email = $_POST["email"];
$pwd = $_POST["pwd"];

//-> is used to access methods of object.
// if used to check if query ran successfully.
if($mysqli->query("INSERT INTO users (fname, lname, address, city, pin, email, password) 
VALUES('$fname', '$lname', '$address', '$city', $pin, '$email', '$pwd')")){
	echo 'Data inserted';
	echo '<br/>';
}
// redirect to login.php
header ("location:../login.php");

?>
