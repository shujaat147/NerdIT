<?php
// using php mailer library.
use PHPMailer\PHPMailer\PHPMailer;
// Simple Mail Transfer Protocol
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require './PHPMailer/Exception.php';
require './PHPMailer/PHPMailer.php';
require './PHPMailer/SMTP.php';

// instance with true for exceptions.
$mail = new PHPMailer(true);

// session start/resume
if (session_id() == '' || !isset($_SESSION)) {
 session_start();
}

//conn file
include 'config.php';


if (isset($_SESSION['cart'])) {
 $total = 0;
 $orderDetails = "";
 // Variable to store order details for mail

 foreach ($_SESSION['cart'] as $product_id => $quantity) {
  //'as' used to assign each element of array to a variable
  //=> separator in an associative array to associate p_id with its value of qty

  $result = $mysqli->query("SELECT * FROM products WHERE p_id = " . $product_id);
  if ($result) {
   if ($obj = $result->fetch_object()) {
    $cost = $obj->price * $quantity;
    $user = $_SESSION["username"];
    $user_id = $_SESSION['u_id'];
    $fullName = $_SESSION['fullName'];
    $userEmail = $_SESSION['username'];

    // Add order details to the summary for mail
    $orderDetails .= '<p><strong>Product Name</strong>: ' . $obj->product_name . '</p>';
    $orderDetails .= '<p><strong>Price Per Unit</strong>: '. $currency . $obj->price . '</p>';
    $orderDetails .= '<p><strong>Units Bought</strong>: ' . $quantity . '</p>';
    $orderDetails .= '<p><strong>Total Cost</strong>: '. $currency . $cost . '</p>';
    $orderDetails .= '<hr>';

    $total += $cost;
   }
  }
 }

 if (!empty($orderDetails)) {
  // tax and Discount calculation
  $taxRate = 0.07;
  $discountRate = 0.1;

  $subtotal = $total;

  // calculate discount
  $discount = 0;
  if ($subtotal >= 1000) {
   $discount = $subtotal * $discountRate;
   $subtotal -= $discount;
   $discountPercentage = $discountRate * 100;

   // add discount details to the summary for mail
   $orderDetails .= '<p><strong>Discount (' . $discountPercentage . '%)</strong>: -' . $currency . number_format($discount, 2) . '</p>';
  }

  // calculate tax
  $taxAmount = $subtotal * $taxRate;

  $grandTotal = $subtotal + $taxAmount;

  // insert order details into the "orders" table for each product
  foreach ($_SESSION['cart'] as $product_id => $quantity) {
   $result = $mysqli->query("SELECT * FROM products WHERE p_id = " . $product_id);

   if ($result) {
    if ($obj = $result->fetch_object()) {
     $cost = $obj->price * $quantity;
     $newqty = $obj->qty - $quantity;

     $insertQuery = $mysqli->query("INSERT INTO orders (user_id, product_id, price, units, tax, discount, total) 
     VALUES ($user_id, $product_id, $obj->price, $quantity, $taxAmount, $discount, $cost)");

     $mysqli->query("UPDATE products SET qty = " . $newqty . " WHERE p_id = " . $product_id);
    }
   }
  }

  // send mail script
  $subject = "Your Order has been placed";
  $message = "<html><body>";
  $message .= '<p><h4>Order Summary</h4></p>';
  $message .= '<p><strong>Full Name</strong>: ' . $fullName . '</p>';
  $message .= '<p><strong>Email</strong>: ' . $userEmail . '</p>';
  $message .= $orderDetails;
  //format a number with thousands by , and 2 decimal places.
  $message .= '<p><strong>Subtotal</strong>: '. $currency . number_format($subtotal, 2) . '</p>';
  $message .= '<p><strong>Tax (' . ($taxRate * 100) . '%)</strong>: '. $currency . number_format($taxAmount, 2) . '</p>';
  $message .= '<p><strong>Grand Total</strong>: '. $currency . number_format($grandTotal, 2) . '</p>';
  $message .= "<h4>Please do not reply to this mail.</h4>";
  $message .= "</body></html>";
  $to = $userEmail;

  try {
   // Set SMTP configuration
   //Using manual
   $mail->isSMTP();
   $mail->Host = 'smtp.gmail.com';
   $mail->SMTPAuth = true;
   $mail->Username = 'donotreply.nerdit@gmail.com';
   $mail->Password = 'ooictrobhoxjvkmv';
   $mail->SMTPSecure = 'tls';
   $mail->Port = 587;

   // Set email content and headers
   $mail->setFrom('donotreply.nerdit@gmail.com', 'NerdIT Support');
   $mail->addAddress($to);
   $mail->isHTML(true);
   $mail->Subject = $subject;
   $mail->Body = $message;

   // Send the email
   // send returns boolean 
   $sent = $mail->send();

   if (!$sent) {
    echo 'Failure: Unable to send email.';
   }
  } catch (Exception $e) {
   echo 'Failure: ' . $mail->ErrorInfo;
  }
 }
}

//emptying cart after sending mail and updating orders 
unset($_SESSION['cart']); 
// redirect to success.php
header("location:../success.php");
