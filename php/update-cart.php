<?php
// This file is connected to prdocuts.php and cart.php
// start/resume session
if (session_id() == '' || !isset($_SESSION)) {
  session_start();
}
// conn file
include 'config.php';

// getting p_id and action mentioned in link
$product_id = $_GET['p_id'];
$action = $_GET['action'];


if ($action === 'empty') {
  // it empty the cart.
  unset($_SESSION['cart']);
  header("location: ../cart.php");
  // Redirect to the cart page
  exit();
  // Terminate further execution
}

//mysqli object to select qty from products.
$result = $mysqli->query("SELECT qty FROM products WHERE p_id = " . $product_id);


if ($result) {
  if ($obj = $result->fetch_object()) {
    // fetching object property of result and assigning to obj data in each row.
    switch ($action) {
      case "add":
        //checks if session card that has specific product id +1 <= qty
        if ($_SESSION['cart'][$product_id] + 1 <= $obj->qty) {
          //if true then cart+1
          $_SESSION['cart'][$product_id]++;
        }
        break;

      case "remove":
        // cart-1
        $_SESSION['cart'][$product_id]--;
        //checking if cart == 0 if yes then unset/clear it.
        if ($_SESSION['cart'][$product_id] == 0) {
          unset($_SESSION['cart'][$product_id]);
        }
        break;
    }
  }
}

//redirect to cart.php
header("location:../cart.php");
