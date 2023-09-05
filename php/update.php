<?php

// session start/remove
if (session_id() == '' || !isset($_SESSION)) {
 session_start();
}

//conn file
include 'config.php';

//post gets the value from form.
$fname = $_POST["fname"];
$lname = $_POST["lname"];
$address = $_POST["address"];
$city = $_POST["city"];
$pin = $_POST["pin"];
$email = $_POST["email"];
$pwd = $_POST["pwd"];


if ($fname != "") {
 $result = $mysqli->query('UPDATE users SET fname ="' . $fname . '" WHERE u_id =' . $_SESSION['u_id']);
 if ($result) {
  $_SESSION['fname'] = $obj->fname;
  $fname = $_SESSION['fname'];
  $fullName = $_SESSION['fname'] . ' ' . $_SESSION['lname'];
  $_SESSION['fullName'] = $fullName;
 }
}

if ($lname != "") {
 $result = $mysqli->query('UPDATE users SET lname ="' . $lname . '" WHERE u_id =' . $_SESSION['u_id']);
 if ($result) {
  $_SESSION['lname'] = $lname;
  $fullName = $_SESSION['fname'] . ' ' . $_SESSION['lname'];
  $_SESSION['fullName'] = $fullName;
 }
}

if ($address != "") {
 $result = $mysqli->query('UPDATE users SET address ="' . $address . '" WHERE u_id =' . $_SESSION['u_id']);
}

if ($city != "") {
 $result = $mysqli->query('UPDATE users SET city ="' . $city . '" WHERE u_id =' . $_SESSION['u_id']);
}

if ($pin != "") {
 $result = $mysqli->query('UPDATE users SET pin =' . $pin . ' WHERE u_id =' . $_SESSION['u_id']);
}

if ($email != "") {
 $result = $mysqli->query('UPDATE users SET email ="' . $email . '" WHERE u_id =' . $_SESSION['u_id']);
 if ($result) {
  $_SESSION['username'] = $username;
 }
}


if ($pwd != "") {
 $query = $mysqli->query('UPDATE users SET password ="' . $pwd . '" WHERE u_id =' . $_SESSION['u_id']);
}

header("location:../success.php");
