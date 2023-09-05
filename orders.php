<?php
// session start/resume
if (session_id() == '' || !isset($_SESSION)) {
  session_start();
}

// if username is not set then goto index.php coz not logged in.
if (!isset($_SESSION["username"])) {
  header("location:index.php");
}
include './php/config.php';
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>My Orders</title>
  <link rel="stylesheet" href="css/index.css" />
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
            <a class="nav-link" href="./cart.php">View Cart</a>
          </li>
          <li class="nav-item">
            <a class="nav-link selectedlink" href="./orders.php">My Orders</a>
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

  <div class="container mt-5">
    <div class="row">
      <div class="col-12">
        <h2 class="text-center text-white mb-5 bg-secondary py-1 rounded">My Orders</h2>
        <div class="row">
          <?php
          //getting u_id from session and assigning to variable.
          $user_id = $_SESSION["u_id"];

          //selecting the users data who is logged in grouping by date and 
          //ordering by date in descending order
          $result = $mysqli->query("SELECT date, SUM(price * units) AS total_price, tax AS total_tax, discount AS total_discount 
            FROM orders WHERE user_id = $user_id GROUP BY date ORDER BY date DESC");
          if ($result) {
            // fetching object property of result and assigning to obj data in each row.
            while ($obj = $result->fetch_object()) {
              echo '<div class="col-lg-6 col-md-12 mb-4 text-center">';
              echo '<div class="card text-white border-success bg-info">';
              echo '<div class="card-header bg-light text-dark border-light"><h4>Order Date: ' . $obj->date . '</h4></div>';
              echo '<div class="card-body">';

              // getting orders for the current date
              $order_date = $obj->date;
              // alias of orders o and prdocuts p.
              // inner join on order and product p_id.
              //where order date and user_id is same.
              $orders_result = $mysqli->query("SELECT o.o_id, p.product_name, o.price, o.units FROM orders AS o 
                INNER JOIN products AS p ON o.product_id = p.p_id 
                WHERE o.user_id = $user_id AND o.date = '$order_date'");
              if ($orders_result) {
                while ($order_obj = $orders_result->fetch_object()) {
                  echo '<p><strong>Order ID:</strong> ' . $order_obj->o_id . '</p>';
                  echo '<p><strong>Product Name:</strong> ' . $order_obj->product_name . '</p>';
                  echo '<p><strong>Price Per Unit:</strong>' . $currency . $order_obj->price . '</p>';
                  echo '<p><strong>Units Bought:</strong> ' . $order_obj->units . '</p>';
                  echo '<hr>';
                }
              }

              echo '<p><strong>Total Price:</strong> ' . $currency . $obj->total_price . '</p>';
              echo '<p><strong>Total Tax:</strong> ' . $currency . $obj->total_tax . '</p>';
              echo '<p><strong>Total Discount:</strong> ' . $currency . $obj->total_discount . '</p>';
              echo '<p><strong>Total Cost:</strong> '  . $currency . ($obj->total_price + $obj->total_tax - $obj->total_discount) . '</p>';
              echo '</div>';
              echo '</div>';
              echo '</div>';
            }
          }
          ?>
        </div>
      </div>
    </div>
  </div>



  <div class="row mt-4 pt-2 pb-0" style="background-color: white; color: black;">
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