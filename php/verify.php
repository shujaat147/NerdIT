<?php
// This file is connected to login.php
//if (session_status() !== PHP_SESSION_ACTIVE) {session_start();}
if (session_id() == '' || !isset($_SESSION)) {
 session_start();
}

include 'config.php';

$username = $_POST["username"];
$password = $_POST["pwd"];
$flag = 'true';
//$query = $mysqli->query("SELECT email, password from users");

$result = $mysqli->query('SELECT u_id,email,password,fname,lname,type from users order by u_id asc');

if ($result === FALSE) {
 die(mysqli_error($mysqli));
}

if ($result) {
 while ($obj = $result->fetch_object()) {
  if ($obj->email === $username && $obj->password === $password) {

   $_SESSION['username'] = $username;
   $_SESSION['type'] = $obj->type;
   $_SESSION['u_id'] = $obj->u_id;
   $_SESSION['fname'] = $obj->fname;
   $_SESSION['lname'] = $obj->lname;
   $fullName = $_SESSION['fname'] . ' ' . $_SESSION['lname'];
   $_SESSION['fullName'] = $fullName;
   header("location:../index.php");
  } else {

   if ($flag === 'true') {
    redirect();
    $flag = 'false';
   }
  }
 }
}

function redirect()
{
 echo '<h1>Invalid Login! Redirecting...</h1>';
 header("Refresh: 3; url=../index.php");
}
