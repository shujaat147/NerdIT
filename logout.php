<?php
// Resuming the session
  session_start();
  // removing the data
  session_unset();
  // destroys the section
  session_destroy();
  // redirect to index.php
  header("location:index.php");
  //terminate execution
  exit();
?>