<?php

if (session_id() == '' || !isset($_SESSION)) {
  session_start();
}

if ($_SESSION["type"] != "admin") {
  header("location:../index.php");
}

include 'config.php';

if (!isset($_SESSION["products_id"])) {
  $_SESSION["products_id"] = array(); // Initialize as an empty array
}

$_SESSION["products_qty"] = $_REQUEST['quantity'];
$_SESSION["products_price"] = $_REQUEST['price'];

$result = $mysqli->query("SELECT * FROM products ORDER BY p_id asc");
$i = 0;

if ($result) {
  while ($obj = $result->fetch_object()) {
    if (empty($_SESSION["products_qty"][$i]) && empty($_SESSION["products_price"][$i])) {
      $i++;
    } else {
      $newQty = $obj->qty + intval($_SESSION["products_qty"][$i]);
      $newPrice = $obj->price + floatval($_SESSION["products_price"][$i]);

      if ($newQty < 0) {
        $newQty = 0; // Prevent negative quantity
      }
      if ($newPrice < 0) {
        $newPrice = 0; // Prevent negative price
      }

      $update = $mysqli->query("UPDATE products SET qty = " . $newQty . ", price = " . $newPrice . " WHERE p_id = " . $obj->p_id);

      if ($update) {
        echo 'Data Updated';
      }
      
      $i++;
    }
  }
}

header("location:../success.php");
?>
