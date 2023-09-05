<?php
// session resume/start
if (session_id() == '' || !isset($_SESSION)) {
  session_start();
}

// conn file
include './php/config.php';
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>View Cart</title>
  <link rel="stylesheet" href="css/index.css" />
  <link rel="stylesheet" href="css/cart.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-0">
    <div class="container-fluid">
      <a class="navbar-brand" href="./index.php"><img class="logo" src="./img/logo.png" alt="NerdIT">NerdIT</a>
      <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav text-center">
          <li class="nav-item">
            <a class="nav-link" href="./products.php">Products</a>
          </li>
          <li class="nav-item">
            <a class="nav-link selectedlink" href="./cart.php">View Cart</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./orders.php">My Orders</a>
          </li>
          <?php
          if (isset($_SESSION['username'])) {
            echo '<li class="nav-item"><a class="nav-link" href="account.php">My Account</a></li>';
            echo '<li class="nav-item"><a class="nav-link" href="logout.php">Log Out</a></li>';
          } else {
            echo '<li class="nav-item"><a class="nav-link" href="login.php">Log In</a></li>';
            echo '<li class="nav-item"><a class=" nav-link" href="register.php">Register</a></li>';
          }
          ?>
        </ul>
      </div>
    </div>
  </nav>


  <div class="container mt-4">
    <h3>Your Shopping Cart</h3>
    <?php

    if (isset($_SESSION['cart'])) {
      $total = 0;

      //tax 7%
      $taxRate = 0.07;
      //discount 10%
      $discountRate = 0.1;

      echo '<div class="receipt">';
      echo '<div class="receipt-header">';
      echo '<div class="receipt-column">Name</div>';
      echo '<div class="receipt-column">Quantity</div>';
      echo '<div class="receipt-column">Cost</div>';
      echo '</div>';


      //'as' used to assign each element of array to a variable
      //=> separator in an associative array to associate p_id with its value of qty
      foreach ($_SESSION['cart'] as $product_id => $quantity) {

        $result = $mysqli->query("SELECT product_code, product_name, product_desc, qty, price FROM products WHERE p_id = " . $product_id);
        if ($result) {
          // result gets the objects of each row and assigns to obj
          while ($obj = $result->fetch_object()) {
            $cost = $obj->price * $quantity;
            echo '<div class="receipt-row">';
            echo '<div class="receipt-column">' . $obj->product_name . '</div>';
            echo '<div class="receipt-column">';
            echo '<div class="quantity">';
            echo '<span class="quantity-label">' . $quantity . '</span>';
            //  query parameters are appended with updatecart.php to do tasks in it using get.
            //? seperated url from parameters
            echo '<a class="btn btn-sm btn-secondary" href="./php/update-cart.php?action=add&p_id=' . $product_id . '">+</a>';
            echo '<a class="btn btn-sm btn-danger" href="./php/update-cart.php?action=remove&p_id=' . $product_id . '">-</a>';
            echo '</div>';
            echo '</div>';
            //format a number with thousands by , and 2 decimal places.
            echo '<div class="receipt-column">'.$currency . number_format($cost, 2) . '</div>';
            echo '</div>';

            $total += $cost; // add to the total cost
          }
        }
      }
      // Calculate discount
      $discount = 0;

      // total is more or equal to $1000 discount is applied
      if ($total >= 1000) {
        $discount = $total * $discountRate;
        $total -= $discount;
        $discountPercentage = $discountRate * 100;
        echo '<div class="receipt-discount">';
        echo '<div class="receipt-column">Discount (' . $discountPercentage . '%)</div>';
        echo '<div class="receipt-column"></div>';
        //format a number with thousands by , and 2 decimal places.
        echo '<div class="receipt-column">'.$currency . number_format($discount, 2) . '</div>';
        echo '</div>';
      }

      // Calculate tax
      $taxAmount = $total * $taxRate;
      $total += $taxAmount;

      echo '<div class="receipt-tax">';
      echo '<div class="receipt-column">Tax (' . ($taxRate * 100) . '%)</div>';
      echo '<div class="receipt-column"></div>';
      //format a number with thousands by , and 2 decimal places.
      echo '<div class="receipt-column">'. $currency . number_format($taxAmount, 2) . '</div>';
      echo '</div>';

      echo '<div class="receipt-total">';
      echo '<div class="receipt-column">Total</div>';
      echo '<div class="receipt-column"></div>';
      //format a number with thousands by , and 2 decimal places.
      echo '<div class="receipt-column">'. $currency . number_format($total, 2) . '</div>';
      echo '</div>';

      echo '<div class="receipt-actions row">';
      //? seperator for query and url.
      echo '<a href="./php/update-cart.php?action=empty" class="col-md-2 col-12 mt-2 btn btn-danger">Empty Cart</a>';
      echo '<a href="products.php" class="col-md-2 col-12 mt-2 btn btn-success"><small>Continue Shopping</small></a>';
      // if session username is set means logged in or not.
      if (isset($_SESSION['username'])) {
        echo '<a href="./php/orders-update.php" class="col-md-2 col-12 mt-2 btn btn-primary">COD</a>';
      } else {
        echo '<a href="login.php" class="col-md-2 col-12 mt-2 btn btn-primary">Login</a>';
      }
      echo '</div>';

      echo '</div>';
    } else {
      echo "You have no items in your shopping cart.";
    }
    ?>
  </div>



  <div class="row mt-4" style="background-color: white; color: black;">
    <div class="col-12">
      <footer>
        <p style="text-align:center; font-size:0.8em;">&copy; NerdIT Tech Shop. All Rights Reserved.</p>
      </footer>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
</body>

</html>